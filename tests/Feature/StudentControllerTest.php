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


        it('admin can create students')->todo();
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

        it('student cannot create students')->todo();
        it('student cannot edit students')->todo();
        it('student cannot delete students')->todo();
    });

});
