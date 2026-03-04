namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        return response()->json(User::all());
    }

    public function register(Request $request) {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }
}