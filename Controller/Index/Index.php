<?php

declare(strict_types=1);

namespace VPT\Todo\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    /**
     * @param Context $context
     * @param Session $session
     */
    public function __construct(
        private readonly Session $session,
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * {@inheritDoc}
     */
    public function execute()
    {
        if (!$this->session->isLoggedIn()) {
            /** @var Redirect $redirect */
            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

            $redirect->setPath('customer/account/login');

            return $redirect;
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}