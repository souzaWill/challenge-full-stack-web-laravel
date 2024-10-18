<?php

use App\Enums\RoleEnum;
use App\Models\Student;

describe('students module', function () {

    it('cannot create student with same document')->todo();
    it('cannot create student with same registration_number')->todo();

    describe('Admin permissions', function () {
        
        it('admin can list students', function(){
            login(RoleEnum::Admin);
            $this->get('api/students')->assertOk()            
                ->assertJsonStructure([
                    'data' => [
                        '*' => [ 
                            'id',
                            'document',
                            'registration_number',
                            'created_at',
                            'updated_at',
                        ],
                    ]
                ]);
        });

        it('admin can view student', function(){
            login(RoleEnum::Admin);
            
            $studentId = Student::inRandomOrder()->first()->id;
            $this->get("api/students/$studentId")->assertOk();
        });


        it('admin can create students', function(){
            login(RoleEnum::Admin);

            $document = fake()->cpf(false);
            $registrationNumber = fake()->randomNumber(7, true);
            $email = fake()->email();
            $name = fake()->name();

            $this->postJson("api/students", [
                'name' => $name,
                'email' => $email,
                'document' => $document,
                'registration_number' => $registrationNumber,
            ])->assertCreated();

            $this->assertDatabaseHas('users', [
                'email' => $email,
                'name' => $name,
            ]);

            $this->assertDatabaseHas('students', [
                'document' => $document,
                'registration_number' => $registrationNumber
            ]);

        });
        it('admin can edit students')->todo();
        it('admin can delete students')->todo();

        it('admin cannot update registration_number')->todo();
        it('admin cannot update document')->todo();
    });

    describe('student permissions', function () {
        
        it('student cannot list students', function(){
            login(RoleEnum::Student);
            $this->get('api/students')->assertForbidden();
        });
        
        it('student cannot view students', function(){
            login(RoleEnum::Student);

            $studentId = Student::inRandomOrder()->first()->id;
            $this->get("api/students/$studentId")->assertForbidden();
        });

        it('student cannot create students', function(){
            login(RoleEnum::Student);

            $document = fake()->cpf(false);
            $registrationNumber = fake()->randomNumber(7, true);
            $email = fake()->email();
            $name = fake()->name();

            $this->postJson("api/students", [
                'name' => $name,
                'email' => $email,
                'document' => $document,
                'registrationNumber' => $registrationNumber,
            ])->assertForbidden();
            
        });
        it('student cannot edit students')->todo();
        it('student cannot delete students')->todo();
    });

});
