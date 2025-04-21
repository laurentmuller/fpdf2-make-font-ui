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
        $builder->add(
            'fontFile',
            FileType::class,
            [
                'label' => 'fields.fontFile',
                'help' => 'helps.fontFile',
                'required' => false,
                'attr' => [
                    'accept' => '.ttf,.otf,.pfb',
                    'autofocus' => 'autofocus',
                ],
            ]
        );

        $builder->add(
            'afmFile',
            FileType::class,
            [
                'label' => 'fields.afmFile',
                'help' => 'helps.afmFile',
                'required' => false,
                'attr' => [
                    'accept' => '.afm',
                    // 'disabled' => 'disabled'
                ],
            ]
        );

        $builder->add(
            'encoding',
            ChoiceType::class,
            [
                'label' => 'fields.encoding',
                'help' => 'helps.encoding',
                'preferred_choices' => ['cp1252'],
                'choice_translation_domain' => false,
                'choices' => [
                    'cp1250 (Central Europe)' => 'cp1250',
                    'cp1251 (Cyrillic)' => 'cp1251',
                    'cp1252 (Western Europe)' => 'cp1252',
                    'cp1253 (Greek)' => 'cp1253',
                    'cp1254 (Turkish)' => 'cp1254',
                    'cp1255 (Hebrew)' => 'cp1255',
                    'cp1257 (Baltic)' => 'cp1257',
                    'cp1258 (Vietnamese)' => 'cp1258',
                    'cp874 (Thai)' => 'cp874',
                    'ISO-8859-1 (Western Europe)' => 'ISO-8859-1',
                    'ISO-8859-2 (Central Europe)' => 'ISO-8859-2',
                    'ISO-8859-4 (Baltic)' => 'ISO-8859-4',
                    'ISO-8859-5 (Cyrillic)' => 'ISO-8859-5',
                    'ISO-8859-7 (Greek)' => 'ISO-8859-7',
                    'ISO-8859-9 (Turkish)' => 'ISO-8859-9',
                    'ISO-8859-11 (Thai)' => 'ISO-8859-11',
                    'ISO-8859-15 (Western Europe)' => 'ISO-8859-15',
                    'ISO-8859-16 (Central Europe)' => 'ISO-8859-16',
                    'KOI8-R (Russian)' => 'KOI8-R',
                    'KOI8-U (Ukrainian)' => 'KOI8-U',
                ],
            ]
        );

        $builder->add(
            'embed',
            CheckboxType::class,
            [
                'label' => 'fields.embed',
                'help' => 'helps.embed',
                'required' => false,
                'label_attr' => [
                    'class' => 'checkbox-switch',
                ],
            ]
        );

        $builder->add(
            'subset',
            CheckboxType::class,
            [
                'label' => 'fields.subset',
                'help' => 'helps.subset',
                'required' => false,
                'label_attr' => [
                    'class' => 'checkbox-switch',
                ],
            ]
        );
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', MakeFontQuery::class);
    }

    #[\Override]
    public function getBlockPrefix(): string
    {
        return 'data';
    }
}
