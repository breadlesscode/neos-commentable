<?php
namespace Breadlesscode\Commentable\Service;

use Breadlesscode\Commentable\Dto\CommentDtoInterface;
use Breadlesscode\Commentable\Exception\InvalidNodeTypeException;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\ContentRepository\Domain\Model\NodeTemplate;
use Neos\ContentRepository\Domain\Service\ContextFactoryInterface;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\Flow\Annotations as Flow;

class CommentService
{
    /**
     * node type of the commentable mixin
     */
    const COMMENTABLE_NODE_TYPE = 'Breadlesscode.Commentable:Mixin.Commentable';

    /**
     * node type of the commentable mixin
     */
    const COMMENT_NODE_TYPE = 'Breadlesscode.Commentable:Content.Comment';

    /**
     * @Flow\Inject()
     * @var ContextFactoryInterface
     */
    protected $contextFactory;

    /**
     * @Flow\InjectConfiguration(path="addToTop")
     * @var ContextFactoryInterface
     */
    protected $addCommentToTop;

    /**
     * @Flow\Inject()
     * @var NodeTypeManager
     */
    protected $nodeTypeManager;

    /**
     * creates a comment node from the CommentDto
     *
     * @param NodeInterface $commentCollection
     * @param CommentDtoInterface $comment
     * @return NodeInterface
     * @throws \Neos\ContentRepository\Exception\NodeTypeNotFoundException
     */
    protected function createNode(NodeInterface $commentCollection, CommentDtoInterface $comment): NodeInterface
    {
        $commentNodeType = $this->nodeTypeManager->getNodeType(self::COMMENT_NODE_TYPE);
        $commentNodeTemplate = new NodeTemplate();
        $commentNodeTemplate->setNodeType($commentNodeType);

        $commentNode = $commentCollection->createNodeFromTemplate($commentNodeTemplate);
        $commentNode->setProperty('name', $comment->getName());
        $commentNode->setProperty('email', $comment->getEmail());
        $commentNode->setProperty('content', $comment->getContent());
        $commentNode->setProperty('createdAt', $comment->getCreatedAt());
        $commentNode->setHidden($comment->isHidden());

        if ($this->addCommentToTop) {
            $firstComment = $commentCollection->getChildNodes(null, 1);
            
            if ($firstComment) {
                $commentNode->moveBefore($firstComment[0]);
            }
        }

        return $commentNode;
    }

    /**
     * adds a comment node to a blog post node
     *
     * @param NodeInterface $commentableNode
     * @param CommentDtoInterface $comment
     * @throws InvalidNodeTypeException
     * @throws \Neos\ContentRepository\Exception\NodeTypeNotFoundException
     */
    public function addComment(NodeInterface $commentableNode, CommentDtoInterface $comment)
    {
        if (!$this->isCommentableNode($commentableNode)) {
            throw new InvalidNodeTypeException('The commentable node type should implement the mixin '.self::COMMENTABLE_NODE_TYPE, 1536244558);
        }

        $this->createNode($commentableNode->getNode('comments'), $comment);
    }

    /**
     * @param string $commentableIdentifier
     * @return NodeInterface|null
     * @throws \Exception
     */
    public function findCommentable(string $commentableIdentifier): ?NodeInterface
    {
        $commentableNode = $this->getContext()->getNodeByIdentifier($commentableIdentifier);

        if (!$this->isCommentableNode($commentableNode)) {
            throw new InvalidNodeTypeException('The commentable node type should implement the mixin '.self::COMMENTABLE_NODE_TYPE, 1536244559);
        }

        return $commentableNode;
    }

    /**
     * @param NodeInterface $node
     * @return bool
     */
    public function isCommentableNode(NodeInterface $node): bool
    {
        return $node->getNodeType()->isOfType(self::COMMENTABLE_NODE_TYPE);
    }

    /**
     * @return \Neos\ContentRepository\Domain\Service\Context
     * @throws \Exception
     */
    protected function getContext()
    {
        return $this->contextFactory->create([
            'workspaceName' => 'live',
            'currentDateTime' => new \Neos\Flow\Utility\Now(),
            'dimensions' => [],
            'invisibleContentShown' => true,
            'removedContentShown' => false,
            'inaccessibleContentShown' => false
        ]);
    }
}
