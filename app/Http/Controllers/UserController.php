namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Get(
        path: "/users",
        summary: "Récupérer la liste des utilisateurs",
        tags: ["Utilisateurs"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste des utilisateurs récupérée avec succès",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(type: "object", properties: [
                        new OA\Property(property: "id", type: "integer", example: 1),
                        new OA\Property(property: "name", type: "string", example: "John Doe"),
                        new OA\Property(property: "email", type: "string", example: "john@example.com")
                    ])
                )
            ),
            new OA\Response(response: 401, description: "Non authentifié")
        ]
    )]
    public function index()
    {
        return response()->json(User::all());
    }
}