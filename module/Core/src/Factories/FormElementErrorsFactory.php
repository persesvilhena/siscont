<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 21/02/2019
 * Time: 00:17
 */

namespace Core\Factories;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Form\View\Helper\FormElementErrors;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;


class FormElementErrorsFactory implements FactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new FormElementErrors();

        $config = $container->get('config');
        if(isset($config['view_helper_config']['form_element_errors'])){
            $configHelper = $config['view_helper_config']['form_element_errors'];
            if(isset($configHelper['message_open_format'])){
                $helper->setMessageOpenFormat($configHelper['message_open_format']);
            }
            if(isset($configHelper['message_separator_string'])){
                $helper->setMessageSeparatorString($configHelper['message_separator_string']);
            }
            if(isset($configHelper['message_close_string'])){
                $helper->setMessageCloseString($configHelper['message_close_string']);
            }
        }

        return $helper;
    }
}