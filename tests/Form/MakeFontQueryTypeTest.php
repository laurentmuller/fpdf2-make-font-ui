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

namespace App\Tests\Form;

use App\Form\MakeFontQueryType;
use App\Model\MakeFontQuery;
use fpdf\FontMaker;
use Symfony\Component\Form\Test\TypeTestCase;

final class MakeFontQueryTypeTest extends TypeTestCase
{
    public function testCustomFormView(): void
    {
        $formData = new MakeFontQuery();
        $view = $this->factory->create(MakeFontQueryType::class, $formData)
            ->createView();
        self::assertArrayHasKey('value', $view->vars);
        self::assertSame($formData, $view->vars['value']);
    }

    public function testSubmitValidData(): void
    {
        $data = [
            'fontFile' => null,
            'afmFile' => null,
            'encoding' => FontMaker::DEFAULT_ENCODING,
            'embed' => true,
            'subset' => true,
        ];

        $model = new MakeFontQuery();
        $form = $this->factory->create(MakeFontQueryType::class, $model);
        $expected = new MakeFontQuery();

        $form->submit($data);
        self::assertTrue($form->isSynchronized());
        self::assertEqualsCanonicalizing($expected, $model);
    }
}
