<?php

namespace Tests\Unit;

use App\Services\CnpjService;
use Tests\TestCase;

class CnpjServiceTest extends TestCase
{
    public function test_it_sanitizes_cnpj_correctly()
    {
        $formatted = '11.222.333/0001-81';
        $expected = '11222333000181';

        $result = CnpjService::sanitize($formatted);

        $this->assertEquals($expected, $result);
    }

    public function test_it_validates_valid_cnpj()
    {
        $validCnpj = '11222333000181';

        $result = CnpjService::isValid($validCnpj);

        $this->assertTrue($result);
    }

    public function test_it_rejects_cnpj_with_wrong_length()
    {
        $shortCnpj = '123456789';
        $longCnpj = '123456789012345';

        $this->assertFalse(CnpjService::isValid($shortCnpj));
        $this->assertFalse(CnpjService::isValid($longCnpj));
    }

    public function test_it_rejects_cnpj_with_all_same_digits()
    {
        $sameCnpj = '11111111111111';

        $result = CnpjService::isValid($sameCnpj);

        $this->assertFalse($result);
    }

    public function test_it_rejects_cnpj_with_invalid_check_digits()
    {
        $invalidCnpj = '11222333000199'; // Wrong check digits

        $result = CnpjService::isValid($invalidCnpj);

        $this->assertFalse($result);
    }

    public function test_it_formats_cnpj_correctly()
    {
        $cnpj = '11222333000181';
        $expected = '11.222.333/0001-81';

        $result = CnpjService::format($cnpj);

        $this->assertEquals($expected, $result);
    }

    public function test_it_formats_already_formatted_cnpj()
    {
        $formattedCnpj = '11.222.333/0001-81';
        $expected = '11.222.333/0001-81';

        $result = CnpjService::format($formattedCnpj);

        $this->assertEquals($expected, $result);
    }
}
