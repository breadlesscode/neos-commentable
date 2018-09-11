<?php
namespace Breadlesscode\Commentable\Form\Finisher;

use Breadlesscode\Commentable\Dto\CommentDto;
use Breadlesscode\Commentable\Exception\InvalidNodeTypeException;
use Breadlesscode\Commentable\Service\CommentService;
use Neos\Form\Core\Model\AbstractFinisher;
use Neos\Flow\Annotations as Flow;

class AddCommentFormFinisher extends AbstractFinisher
{
    /**
     * @var CommentService
     * @Flow\Inject()
     */
    protected $commentService;

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
     * @return CommentDto
     */
    protected function getCommentDto(): CommentDto
    {
        $comment = new CommentDto();
        $comment->setName($this->parseOption('name'));
        $comment->setEmail($this->parseOption('email'));
        $comment->setContent($this->parseOption('content'));
        $comment->setIsHidden(true);

        return $comment;
    }
}
