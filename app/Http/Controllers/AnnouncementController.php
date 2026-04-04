namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
public function store(Request $request)
{
$request->validate([
'title' => 'required|string|max:255',
'content' => 'required|string',
'target' => 'required|in:all,student,staff',
]);

Announcement::create([
'title' => $request->title,
'content' => $request->content,
'target' => $request->target,
'user_id' => Auth::id(),
]);

return redirect()->back()->with('success', 'Announcement posted successfully!');
}

public function destroy(Announcement $announcement)
{
// Security check: Only staff/admin can delete
if (Auth::user()->role === 'student') {
return redirect()->back()->with('error', 'You do not have permission to delete this.');
}

$announcement->delete();

return redirect()->back()->with('success', 'Announcement deleted!');
}
}