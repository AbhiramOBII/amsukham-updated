<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submission_succeeds(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '9876543210',
            'subject' => 'Inquiry',
            'message' => 'I would like to know about silk sarees.',
        ]);

        $response->assertRedirect(route('contact'));
        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_contact_form_requires_name(): void
    {
        $response = $this->post('/contact', [
            'email' => 'john@example.com',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_contact_form_requires_valid_email(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John',
            'email' => 'not-an-email',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_contact_form_requires_message(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John',
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('message');
    }

    public function test_contact_form_validates_phone_format(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John',
            'email' => 'john@example.com',
            'phone' => '12345',
            'message' => 'Test',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_contact_form_name_rejects_special_characters(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John@123',
            'email' => 'john@example.com',
            'message' => 'Test',
        ]);

        $response->assertSessionHasErrors('name');
    }
}
