<?php
namespace Breadlesscode\Commentable\Form\Finisher;

use Breadlesscode\Commentable\Dto\CommentDtoInterface;
use Breadlesscode\Commentable\Exception\InvalidNodeTypeException;
use Breadlesscode\Commentable\Service\CommentService;
use Neos\Form\Core\Model\AbstractFinisher;
use Neos\Flow\Annotations as Flow;

class AddCommentFormFinisher extends AbstractFinisher
{
    /**
     * @var \Neos\Flow\ObjectManagement\ObjectManagerInterface
     * @Flow\Inject()
     */
    protected $objectManager;

    /**
     * @var CommentService
     * @Flow\Inject()
     */
    protected $commentService;

    /**
     * @var bool
     * @Flow\InjectConfiguration(path="hidden")
     */
    protected $defaultHidden;

    /**
     * this finisher adds a comment to a given node
     */
    protected function executeInternal()
    {
        try {
            $commentableNode = $this->parseOption('node');

            if ($commentableNode === null) {
                throw new InvalidNodeTypeException('Node should be of type '.CommentService::COMMENTABLE_NODE_TYPE.' null given.', 1536671893);
            }

            $this->commentService->addComment($commentableNode, $this->getCommentDto());
        } catch (\Exception | InvalidNodeTypeException $exception) {
            $this->finisherContext->cancel();
        }
    }

    /**
     * @return CommentDtoInterface
     */
    protected function getCommentDto(): CommentDtoInterface
    {
        $comment = $this->objectManager->get(CommentDtoInterface::class);
        $comment->setName($this->parseOption('name'));
        $comment->setEmail($this->parseOption('email'));
        $comment->setContent($this->parseOption('content'));
        $comment->setIsHidden($this->defaultHidden);

        return $comment;
    }

    /**
     * @return mixed
     */
    public function getOption($optionName)
    {
        return $this->parseOption($optionName);
    }
}
