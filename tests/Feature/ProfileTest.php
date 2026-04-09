<?php

namespace Tests\Feature;

use App\Models\Iglesia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests del portal de iglesias (Step 3-5).
 * Cubre: autenticación dual, middlewares de rol y páginas del portal.
 */
class ProfileTest extends TestCase
{
    use RefreshDatabase;

    // ─── helpers ────────────────────────────────────────────────

    private function makeIglesia(): Iglesia
    {
        return Iglesia::create([
            'official_name' => 'Iglesia de Prueba',
            'denomination'  => 'Evangélica',
        ]);
    }

    private function makeIglesiaUser(Iglesia $iglesia): User
    {
        return User::factory()->create([
            'role'       => 'iglesia',
            'username'   => 'iglesia_test',
            'iglesia_id' => $iglesia->id,
            'email'      => 'iglesia_test@portal.local',
        ]);
    }

    // ─── Middleware: admin no puede acceder al portal iglesia ──

    public function test_admin_cannot_access_iglesia_portal(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/iglesia/dashboard')
            ->assertStatus(403);
    }

    // ─── Middleware: invitado redirige a login ──────────────────

    public function test_guest_is_redirected_from_iglesia_portal(): void
    {
        $this->get('/iglesia/dashboard')
            ->assertRedirect('/login');
    }

    // ─── Portal: iglesia ve su dashboard ───────────────────────

    public function test_iglesia_user_can_see_dashboard(): void
    {
        $iglesia = $this->makeIglesia();
        $user    = $this->makeIglesiaUser($iglesia);

        $this->actingAs($user)
            ->get('/iglesia/dashboard')
            ->assertOk()
            ->assertSee($iglesia->official_name);
    }    // ─── Portal: iglesia ve índice de eventos ──────────────────

    public function test_iglesia_user_can_see_eventos_index(): void
    {
        $iglesia = $this->makeIglesia();
        $user    = $this->makeIglesiaUser($iglesia);

        $this->actingAs($user)
            ->get('/iglesia/eventos')
            ->assertOk();
    }

    // ─── Portal: iglesia ve formulario de creación de evento ───

    public function test_iglesia_user_can_see_evento_create_form(): void
    {
        $iglesia = $this->makeIglesia();
        $user    = $this->makeIglesiaUser($iglesia);

        $this->actingAs($user)
            ->get('/iglesia/eventos/create')
            ->assertOk();
    }

    // ─── Portal: iglesia ve índice de emprendimientos ──────────

    public function test_iglesia_user_can_see_emprendimientos_index(): void
    {
        $iglesia = $this->makeIglesia();
        $user    = $this->makeIglesiaUser($iglesia);

        $this->actingAs($user)
            ->get('/iglesia/emprendimientos')
            ->assertOk();
    }

    // ─── Admin: puede asignar credenciales a una iglesia ───────

    public function test_admin_can_set_iglesia_credentials(): void
    {
        $admin   = User::factory()->create(['role' => 'admin']);
        $iglesia = $this->makeIglesia();

        $response = $this->actingAs($admin)->post(
            route('admin.iglesias.credentials', $iglesia),
            [
                'username'              => 'nueva_iglesia',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123',
            ]
        );

        $response->assertRedirect(route('admin.iglesias.edit', $iglesia));

        $this->assertDatabaseHas('users', [
            'username'   => 'nueva_iglesia',
            'role'       => 'iglesia',
            'iglesia_id' => $iglesia->id,
        ]);
    }

    // ─── Admin: duplicate username is rejected ─────────────────

    public function test_duplicate_username_is_rejected(): void
    {
        $admin    = User::factory()->create(['role' => 'admin']);
        $iglesia  = $this->makeIglesia();
        $iglesia2 = Iglesia::create(['official_name' => 'Otra iglesia']);

        // create first user with that username
        User::factory()->create(['username' => 'ya_existe', 'role' => 'iglesia']);

        $response = $this->actingAs($admin)->post(
            route('admin.iglesias.credentials', $iglesia2),
            [
                'username'              => 'ya_existe',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123',
            ]
        );

        $response->assertSessionHasErrors('username');
    }
}

