<?php

describe('students module', function () {

    it('cannot create student with same document')->todo();
    it('cannot create student with same registration_number')->todo();

    describe('Admin permissions', function () {
        it('admin can list students')->todo();
        it('admin can create students')->todo();
        it('admin can edit students')->todo();
        it('admin can delete students')->todo();

        it('admin cannot update registration_number')->todo();
        it('admin cannot update document')->todo();
    });

    describe('student permissions', function () {
        it('student cannot list students')->todo();
        it('student cannot create students')->todo();
        it('student cannot edit students')->todo();
        it('student cannot delete students')->todo();
    });

});
