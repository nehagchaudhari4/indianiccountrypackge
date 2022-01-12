<?php

namespace Indianiic\Country\Forms;

use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

class CountryForm extends Form
{
    public function buildForm()
    {
        $this->add('name', Field::TEXT, ['label' => 'Name', 'label_attr' => ['class' => 'required-asterisk']])
            ->add('country_code', Field::TEXT, ['label' => 'Country Code', 'attr' => ['maxlength' => '2'], 'label_attr' => ['class' => 'required-asterisk']])
            ->add('flag', Field::FILE, [
                'label' => 'Country Flag',
                'attr' => [
                    'class' => 'dropify form-control',
                    'data-show-remove'=>"false",
                    'data-default-file' => $this->getData('flag')
                ]
            ])
            ->add('phone_code', Field::NUMBER, ['label' => 'Phone Code', 'label_attr' => ['class' => 'required-asterisk']])
            ->add('status', Field::SELECT, [
                'choices' => getEnumValues('countries', 'status')
            ])
            ->add('submit', 'submit', [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-primary mr-3 ml-3'
                ]
            ])
            ->add('clear', 'button', [
                'label' => 'Cancel',
                'attr' => [
                    'class' => 'btn btn-light-secondary',
                    'onclick' => 'window.location="'.route('admin.countries.index').'"'
                ]
            ]);
    }
}
