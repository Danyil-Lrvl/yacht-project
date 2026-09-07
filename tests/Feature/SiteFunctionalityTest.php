<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Yacht;
use App\Models\ClientYacht;
use App\Models\RentYacht;
use App\Models\ProdazhaYacht;

class SiteFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    private function createTestYacht($typeOper = 'rent')
    {
        return Yacht::create([
            'name' => 'Test Yacht Alpha',
            'status' => 'available',
            'type_id' => 1,
            'serial_number' => 'SN-12345',
            'year' => 2023,
            'price_rent' => 1000,
            'price_buy' => 50000,
            'type_oper' => $typeOper,
            'is_active' => 1,
        ]);
    }

    // 1. Головна сторінка
    public function test_main_page_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // 2. Сторінка оренди конкретної яхти
    public function test_yacht_rent_form_page_is_accessible()
    {
        $yacht = $this->createTestYacht('rent');

        $response = $this->get("/yacht/rent/{$yacht->id}");
        
        $response->assertStatus(200);
        $response->assertSee($yacht->name);
    }

    // 3. Сторінка купівлі конкретної яхти
    public function test_yacht_buy_form_page_is_accessible()
    {
        $yacht = $this->createTestYacht('buy');

        $response = $this->get("/yacht/buy/{$yacht->id}");
        
        $response->assertStatus(200);
        $response->assertSee($yacht->name);
    }

    // 4. Реєстрація клієнта
    public function test_client_can_register()
    {
        $response = $this->post('/client/register', [
            'full_name' => 'Принц Ян',
            'name' => 'Принц Ян',
            'email' => 'prince.yan@example.com',
            'phone' => '+380991234567',
            'password' => 'securepassword123',
            'password_confirmation' => 'securepassword123'
        ]);

        $this->assertDatabaseHas('clients_yachts', ['email' => 'prince.yan@example.com']);
    }

    // 5. Успішний вхід клієнта
    public function test_client_can_login_with_correct_credentials()
    {
        $client = ClientYacht::create([
            'full_name' => 'Test Client',
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/client/login', [
            'email' => 'client@example.com',
            'password' => 'password123'
        ]);

        $this->assertAuthenticatedAs($client, 'client');
    }

    // 6. Помилка входу з невірними даними
    public function test_client_login_fails_with_invalid_data()
    {
        $response = $this->post('/client/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('client');
    }

    // 7. Подання заявки на купівлю яхти
    public function test_client_can_submit_yacht_buy_request()
    {
        $client = ClientYacht::create([
            'full_name' => 'Test Client',
            'name' => 'Test Client',
            'email' => 'client_buy@example.com',
            'password' => bcrypt('password123')
        ]);
        
        $yacht = $this->createTestYacht('buy');

        $response = $this->actingAs($client, 'client')
             ->post('/yacht/buy/submit', [
                 'yacht_id' => $yacht->id,
                 'full_name' => 'Принц Ян',
                 'phone' => '+380991234567',
                 'email' => 'prince@example.com',
             ]);

        $this->assertDatabaseHas('prodazha_yachts', [
            'yacht_id' => $yacht->id,
            'client_id' => $client->id,
        ]);
    }

    // 8. Подання заявки на оренду яхти
    public function test_client_can_submit_yacht_rent_booking()
    {
        $client = ClientYacht::create([
            'full_name' => 'Test Client',
            'name' => 'Test Client',
            'email' => 'client_rent@example.com',
            'password' => bcrypt('password123')
        ]);
        
        $yacht = $this->createTestYacht('rent');

        $response = $this->actingAs($client, 'client')
             ->post('/yacht/rent/submit', [
                 'yacht_id' => $yacht->id,
                 'full_name' => 'Принц Ян',
                 'phone' => '+380991234567',
                 'email' => 'prince@example.com',
                 'document_number' => 'AB123456',
                 'document_date' => '2020-05-10',
                 'document_issued_by' => 'МВВС України',
                 'address' => 'м. Київ',
                 'tax_id' => '1234567890',
                 'initial_price_per_day' => 1000,
                 'start_date' => '2026-10-01',
                 'end_date' => '2026-10-05',
             ]);

        $this->assertDatabaseHas('rent_yachts', [
            'yacht_id' => $yacht->id,
            'client_id' => $client->id,
        ]);
    }

    // 9. Перевірка API заброньованих дат
    public function test_booked_dates_api_returns_correct_json()
    {
        $client = ClientYacht::create([
            'full_name' => 'Test Client',
            'name' => 'Test Client',
            'email' => 'client_api@example.com',
            'password' => bcrypt('password123')
        ]);
        
        $yacht = $this->createTestYacht('rent');

        RentYacht::create([
            'yacht_id' => $yacht->id,
            'client_id' => $client->id,
            'start_date' => '2026-11-01',
            'end_date' => '2026-11-03',
            'amount' => 3000,
            'status' => 'заявка',
        ]);

        $response = $this->get("/yacht/booked-dates/{$yacht->id}");
        
        $response->assertStatus(200);
        $response->assertJsonFragment(['2026-11-01']);
    }

    // 10. Вихід клієнта з системи
    public function test_client_can_logout()
    {
        $client = ClientYacht::create([
            'full_name' => 'Test Client',
            'name' => 'Test Client',
            'email' => 'client_logout@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->actingAs($client, 'client')
             ->post('/client/logout');

        $response->assertRedirect('/');
        $this->assertGuest('client');
    }
}