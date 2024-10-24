<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Services\Students\StudentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * @group Estudantes
 */
class StudentController extends Controller
{
    public function __construct(protected StudentServiceInterface $studentService) {}

    /**
     * Exibe uma lista de estudantes com paginação e busca.
     *
     *
     * @queryParam page int O número da página a ser retornada (default: 1). 
     * @queryParam per_page int O número de registros por página (default: 10). 
     * @queryParam search string O termo para busca pelo nome do usuário.
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "document": "29436900589",
     *             "user": {
     *                 "id": 2,
     *                 "name": "Benjamin Carmona Jr.",
     *                 "email": "padilha.sophia@example.net",
     *                 "email_verified_at": "2024-10-23T22:26:06.000000Z",
     *                 "role": 2,
     *                 "created_at": "2024-10-23T22:26:06.000000Z",
     *                 "updated_at": "2024-10-23T22:26:06.000000Z"
     *             },
     *             "registration_number": "99331603",
     *             "created_at": "2024-10-23T22:26:06.000000Z",
     *             "updated_at": "2024-10-23T22:26:06.000000Z"
     *         },
     *     ],
     * }
     *
     * @response 401 {
     *     "message": "Não autorizado."
     * }
     *
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Student::class);

        if ($request->search) {
            $students = $this->studentService->findByUserName(
                $request->search,
            );

            return StudentResource::collection($students);

        }

        $students = $this->studentService->list(
            $request->per_page,
        );

        return StudentResource::collection($students);
    }

    /**
     * Cria um novo estudante.
     *
     * @bodyParam document string required CPF do estudante. Exemplo: 29436900589
     * @bodyParam registration_number string required Número de registro do estudante. Exemplo: 99331603
     * @bodyParam name string required Nome do estudante. Exemplo: 'Benjamin Carmona Jr'
     * @bodyParam email string required Email do estudante. Exemplo: 'padilha.sophia@example.net'
     *
     * @response 201 {
     *     "id": 1,
     *     "document": "29436900589",
     *     "user": {
     *         "id": 2,
     *         "name": "Benjamin Carmona Jr.",
     *         "email": "padilha.sophia@example.net",
     *         "email_verified_at": "2024-10-23T22:26:06.000000Z",
     *         "role": 2,
     *         "created_at": "2024-10-23T22:26:06.000000Z",
     *         "updated_at": "2024-10-23T22:26:06.000000Z"
     *     },
     *     "registration_number": "99331603",
     *     "created_at": "2024-10-23T22:26:06.000000Z",
     *     "updated_at": "2024-10-23T22:26:06.000000Z"
     * }
     *
     * }
     *
     */
    public function store(StoreStudentRequest $request)
    {
        $student = $this->studentService->create($request->validated());

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(201);

    }

    /**
     * Exibe um estudante específico.
     *
     * @urlParam student int required O ID do estudante. Exemplo: 1
     *
     * @response 200 {
     *     "id": 1,
     *     "document": "29436900589",
     *     "user": {
     *         "id": 2,
     *         "name": "Benjamin Carmona Jr.",
     *         "email": "padilha.sophia@example.net",
     *         "email_verified_at": "2024-10-23T22:26:06.000000Z",
     *         "role": 2,
     *         "created_at": "2024-10-23T22:26:06.000000Z",
     *         "updated_at": "2024-10-23T22:26:06.000000Z"
     *     },
     *     "registration_number": "99331603",
     *     "created_at": "2024-10-23T22:26:06.000000Z",
     *     "updated_at": "2024-10-23T22:26:06.000000Z"
     * }
     *
     *
     */
    public function show(Student $student)
    {
        Gate::authorize('view', $student);

        return new StudentResource($student);
    }

     /**
     * Atualiza as informações de um estudante específico.
     *
     * @urlParam student int required O ID do estudante a ser atualizado. Exemplo: 1
     *
     * @bodyParam name string required O nome do estudante. Exemplo: "Benjamin Carmona Jr."
     * @bodyParam email string required O e-mail do estudante. Deve ser único. Exemplo: "benjamin@example.com"
     *
     * @response 200 {
     *     "id": 1,
     *     "document": "29436900589",
     *     "user": {
     *         "id": 2,
     *         "name": "Benjamin Carmona Jr.",
     *         "email": "benjamin@example.com",
     *         "email_verified_at": "2024-10-23T22:26:06.000000Z",
     *         "role": 2,
     *         "created_at": "2024-10-23T22:26:06.000000Z",
     *         "updated_at": "2024-10-23T22:26:06.000000Z"
     *     },
     *     "registration_number": "99331603",
     *     "created_at": "2024-10-23T22:26:06.000000Z",
     *     "updated_at": "2024-10-23T22:26:06.000000Z"
     * }
     *
     *
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student = $this->studentService->update(
            $student,
            $request->validated()
        );

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove um estudante específico.
     *
     * @urlParam student int required O ID do estudante a ser removido. Exemplo: 1
     *
     * @response 204 {}
     *
     */
    public function destroy(Student $student)
    {
        Gate::authorize('delete', $student);

        $student = $this->studentService->delete(
            $student
        );

        return response()->noContent();
    }
}
