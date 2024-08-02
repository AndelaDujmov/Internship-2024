<?php

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Form\FormEvent;


#[AsEventListener]
class FormSubmitListener {
    public function onSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $form->getData();
    }
}