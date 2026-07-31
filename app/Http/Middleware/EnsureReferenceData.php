<?php

namespace App\Http\Middleware;

use App\Models\AboutSubject;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class EnsureReferenceData
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Schema::hasTable('roles') && ! Role::query()->exists()) {
            Role::query()->create(['slug' => 'administrator', 'role_name' => ['en' => 'Administrator', 'fr' => 'Administrateur', 'es' => 'Administrador'], 'role_description' => ['en' => 'Platform operations data management.', 'fr' => 'Gestion des données du fonctionnement de la plateforme.', 'es' => 'Gestión de los datos operativos de la plataforma.']]);
            Role::query()->create(['slug' => 'member', 'role_name' => ['en' => 'Member', 'fr' => 'Membre', 'es' => 'Miembro'], 'role_description' => ['en' => 'A person who saves and can receive money.', 'fr' => 'Personne qui épargne son argent et qui est en mesure de recevoir de l’argent.', 'es' => 'Persona que ahorra y puede recibir dinero.']]);
            Role::query()->create(['slug' => 'partner', 'role_name' => ['en' => 'Partner', 'fr' => 'Partenaire', 'es' => 'Socio'], 'role_description' => ['en' => 'A person who wants to advertise on the platform.', 'fr' => 'Personne qui veut mettre sa publicité sur la plateforme.', 'es' => 'Persona que desea anunciarse en la plataforma.']]);
        }
        if (Schema::hasTable('about_subjects') && ! AboutSubject::query()->exists()) {
            AboutSubject::query()->create(['subject' => ['en' => 'About', 'fr' => 'À propos', 'es' => 'Acerca de'], 'description' => ['en' => 'Introducing Businos Line, your online tontine platform.', 'fr' => 'Présentation de « Businos Line », votre plateforme de Tontine.', 'es' => 'Presentación de Businos Line, su plataforma de tontina.'], 'is_available' => true]);
            AboutSubject::query()->create(['subject' => ['en' => 'Terms of use', 'fr' => 'Conditions d’utilisation', 'es' => 'Condiciones de uso'], 'description' => ['en' => 'Please read our terms carefully before accepting this binding agreement.', 'fr' => 'Veuillez lire attentivement nos conditions, car vous êtes sur le point d’accepter un contrat qu’il faudra respecter.', 'es' => 'Lea atentamente nuestras condiciones antes de aceptar este contrato.'], 'is_available' => true]);
            AboutSubject::query()->create(['subject' => ['en' => 'Privacy policy', 'fr' => 'Politique de confidentialité', 'es' => 'Política de privacidad'], 'description' => ['en' => 'Your privacy and transaction security are our priority.', 'fr' => 'Votre vie privée est notre priorité ; mais aussi la sécurité de vos transactions d’argent.', 'es' => 'Su privacidad y la seguridad de sus transacciones son nuestra prioridad.'], 'is_available' => true]);
        }

        return $next($request);
    }
}
