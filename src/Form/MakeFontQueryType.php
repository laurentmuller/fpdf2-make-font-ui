<?php

/*
 * This file is part of the 'fpdf2-make-font-ui' package.
 *
 * For the license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author bibi.nu <bibi@bibi.nu>
 */

declare(strict_types=1);

namespace App\Form;

use App\Model\MakeFontQuery;
use fpdf\FontMaker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MakeFontQueryType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addFile($builder, 'fontFile', '.ttf,.otf,.pfb', true);
        $this->addFile($builder, 'afmFile', '.afm');
        $this->addEncoding($builder);
        $this->addCheckBox($builder, 'embed');
        $this->addCheckBox($builder, 'subset');
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', MakeFontQuery::class);
    }

    #[\Override]
    public function getBlockPrefix(): string
    {
        return '';
    }

    private function addCheckBox(FormBuilderInterface $builder, string $id): void
    {
        $builder->add(
            $id,
            CheckboxType::class,
            [
                'label' => 'fields.' . $id,
                'help' => 'helps.' . $id,
                'required' => false,
                'label_attr' => [
                    'class' => 'checkbox-switch',
                ],
            ]
        );
    }

    private function addEncoding(FormBuilderInterface $builder): void
    {
        $builder->add(
            'encoding',
            ChoiceType::class,
            [
                'label' => 'fields.encoding',
                'help' => 'helps.encoding',
                'choice_translation_domain' => false,
                'choices' => FontMaker::getEncodings(),
            ]
        );
    }

    private function addFile(
        FormBuilderInterface $builder,
        string $id,
        string $accept,
        bool $autofocus = false
    ): void {
        $attr = [
            'accept' => $accept,
        ];
        if ($autofocus) {
            $attr['autofocus'] = 'autofocus';
        }
        $builder->add(
            $id,
            FileType::class,
            [
                'label' => 'fields.' . $id,
                'help' => 'helps.' . $id,
                'required' => false,
                'attr' => $attr,
            ]
        );
    }
}
