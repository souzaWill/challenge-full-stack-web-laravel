<?php

use App\Enums\RoleEnum;
use App\Models\Student;

describe('students module', function () {

    describe('Admin permissions', function () {

        it('admin can list students', function () {
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
                    ],
                ]);
        });

        it('admin can search students', function () {
            login(RoleEnum::Admin);
            $studentName = Student::inRandomOrder()->first()->user->name;

            $this->get("api/students?search=$studentName")->assertOk()
                ->assertJsonCount(1,"data")
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'document',
                            'registration_number',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ]);
        });

        it('admin can list students paginated', function () {
            login(RoleEnum::Admin);

            $this->get("api/students?page=1&per_page=10")->assertOk()
                ->assertJsonCount(10,"data")
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'document',
                            'registration_number',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ]);
        });

        it('admin can view student', function () {
            login(RoleEnum::Admin);

            $studentId = Student::inRandomOrder()->first()->id;
            $this->get("api/students/$studentId")->assertOk();
        });

        it('admin can create students', function () {
            login(RoleEnum::Admin);

            $document = fake()->cpf(false);
            $registrationNumber = fake()->randomNumber(8, true);
            $email = fake()->email();
            $name = fake()->name();

            $this->postJson('api/students', [
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
                'registration_number' => $registrationNumber,
            ]);

        });

        it('admin cannot create student with same document', function () {
            login(RoleEnum::Admin);

            $student = Student::inRandomOrder()->first();

            $document = $student->document;
            $registrationNumber = fake()->randomNumber(8, true);
            $email = fake()->email();
            $name = fake()->name();

            $this->postJson('api/students', [
                'name' => $name,
                'email' => $email,
                'document' => $document,
                'registration_number' => $registrationNumber,
            ])->assertInvalid([
                'document',
            ]);

            $this->assertDatabaseMissing('students', [
                'document' => $document,
                'registration_number' => $registrationNumber,
            ]);

        });

        it('cannot create student with same registration_number', function () {
            login(RoleEnum::Admin);

            $student = Student::inRandomOrder()->first();

            $document = fake()->cpf(false);
            $registrationNumber = $student->registration_number;
            $email = fake()->email();
            $name = fake()->name();

            $this->postJson('api/students', [
                'name' => $name,
                'email' => $email,
                'document' => $document,
                'registration_number' => $registrationNumber,
            ])->assertInvalid([
                'registration_number',
            ]);

            $this->assertDatabaseMissing('students', [
                'document' => $document,
                'registration_number' => $registrationNumber,
            ]);

        });

        it('admin can update students', function () {
            login(RoleEnum::Admin);

            $student = Student::inRandomOrder()->first();
            $studentId = $student->id;

            $email = fake()->email();
            $name = fake()->name();

            $this->putJson("api/students/$studentId", [
                'name' => $name,
                'email' => $email,
            ])->assertOk();

            $this->assertDatabaseHas('users', [
                'email' => $email,
                'name' => $name,
            ]);

            $this->assertDatabaseHas('students', [
                'document' => $student->document,
                'registration_number' => $student->registration_number,
            ]);
        });

        it('admin cannot update document', function () {
            login(RoleEnum::Admin);

            $student = Student::inRandomOrder()->first();
            $studentId = $student->id;

            $email = fake()->email();
            $name = fake()->name();
            $document = fake()->cpf(false);

            $this->putJson("api/students/$studentId", [
                'name' => $name,
                'email' => $email,
                'document' => $document,
            ])->assertOk();

            $this->assertDatabaseHas('users', [
                'email' => $email,
                'name' => $name,
            ]);

            $this->assertDatabaseMissing('students', [
                'document' => $document,
            ]);
        });

        it('admin cannot update registration_number', function () {
            login(RoleEnum::Admin);

            $student = Student::inRandomOrder()->first();
            $studentId = $student->id;

            $email = fake()->email();
            $name = fake()->name();
            $registrationNumber = fake()->randomNumber(8, true);

            $this->putJson("api/students/$studentId", [
                'name' => $name,
                'email' => $email,
                'registration_number' => $registrationNumber,
            ])->assertOk();

            $this->assertDatabaseHas('users', [
                'email' => $email,
                'name' => $name,
            ]);

            $this->assertDatabaseMissing('students', [
                'registration_number' => $registrationNumber,
            ]);
        });

        it('admin can delete students', function () {
            login(RoleEnum::Admin);
            $student = Student::inRandomOrder()->first();
            $studentId = $student->id;
            $userId = $student->user->id;

            $this->delete("api/students/$studentId")->assertNoContent();

            $this->assertDatabaseMissing('students', [
                'id' => $studentId,
            ]);

            $this->assertDatabaseMissing('users', [
                'id' => $userId,
            ]);

        });

    });

    describe('student permissions', function () {

        it('student cannot list students', function () {
            login(RoleEnum::Student);
            $this->get('api/students')->assertForbidden();
        });

        it('student cannot view students', function () {
            login(RoleEnum::Student);

            $studentId = Student::inRandomOrder()->first()->id;
            $this->get("api/students/$studentId")->assertForbidden();
        });

        it('student cannot create students', function () {
            login(RoleEnum::Student);

            $document = fake()->cpf(false);
            $registrationNumber = fake()->randomNumber(8, true);
            $email = fake()->email();
            $name = fake()->name();

            $this->postJson('api/students', [
                'name' => $name,
                'email' => $email,
                'document' => $document,
                'registrationNumber' => $registrationNumber,
            ])->assertForbidden();

        });
        it('student cannot edit students', function () {
            login(RoleEnum::Student);

            $student = Student::inRandomOrder()->first();
            $studentId = $student->id;

            $email = fake()->email();
            $name = fake()->name();

            $this->putJson("api/students/$studentId", [
                'name' => $name,
                'email' => $email,
            ])->assertForbidden();
        });
        it('student cannot delete students', function () {
            login(RoleEnum::Student);
            $student = Student::inRandomOrder()->first();
            $studentId = $student->id;
            $userId = $student->user->id;

            $this->delete("api/students/$studentId")->assertForbidden();

            $this->assertDatabaseHas('students', [
                'id' => $studentId,
            ]);

            $this->assertDatabaseHas('users', [
                'id' => $userId,
            ]);

        });
    });

});
