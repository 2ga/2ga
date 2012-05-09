<?php

/**
 * ShelfUser form.
 *
 * @package    anyshelf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendIdeKeyForm extends BaseIdeKeyForm
{

    public function configure() {


        unset($this->validatorSchema['created_at']);
        unset($this['created_at']);
        unset($this->validatorSchema['updated_at']);
        unset($this['updated_at']);
        unset($this->validatorSchema['pubkey']);
        unset($this['pubkey']);
        unset($this->validatorSchema['ide_user_id']);
        unset($this['ide_user_id']);
        $this->getValidator('description')->setOption('required', false);
        $this->getValidator('name')->setOption('required', true);
        
    }

}
