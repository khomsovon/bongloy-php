<?php
namespace Bongloy;

use \PHPUnit\Framework\TestCase;

final class SourceTest extends TestCase
{
    use TestHelper;

    public function testCreatable()
    {
        $customer = Customer::create([
            'email' => "user@example.com",
            'description' => 'Bongloy customer',
            'source' => $this->token()->id
        ]);

        $card = Customer::createSource(
            $customer->id,
            ['source' => $this->token()->id]
        );

        $this->assertEquals($card->customer, $customer->id);
    }

    public function testIsListable()
    {
        $customer = Customer::create([
            'email' => "user@example.com",
            'description' => 'Bongloy customer',
            'source' => $this->token()->id
        ]);

        $card = Customer::createSource(
            $customer->id,
            ['source' => $this->token()->id]
        );

        $cards = Customer::allSources($customer->id, ['limit' => 30]);

        $this->assertArrayHasKey($card->id, array_column($cards->data, 'customer', 'id'));
    }

    public function testIsRetrievable()
    {
        $customer = Customer::create([
            'email' => "user@example.com",
            'description' => 'Bongloy customer',
            'source' => $this->token()->id
        ]);

        $card = Customer::createSource(
            $customer->id,
            ['source' => $this->token()->id]
        );

        $result = Customer::retrieveSource($customer->id, $card->id);

        $this->assertEquals($result->id, $card->id);
    }

    public function testIsDeletable()
    {
        $this->markTestSkipped('must be revisited.');

        $customer = Customer::create([
            'email' => "user@example.com",
            'description' => 'Bongloy customer',
            'source' => $this->token()->id
        ]);

        $card = Customer::createSource(
            $customer->id,
            ['source' => $this->token()->id]
        );

        $result = Customer::deleteSource($customer->id, $card->id);

        $this->assertEquals($result.deleted, true);
    }

    private function token()
    {
        $token = Token::create([
            'card' => [
              'number' => '6200000000000005',
              'exp_month' => 2,
              'exp_year' => 2021,
              'cvc' => '123',
            ],
        ]);

        return $token;
    }
}
