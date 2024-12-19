namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Display the review form
    public function create($sessionId)
    {
        $session = Session::findOrFail($sessionId);
        return view('reviews.create', compact('session'));
    }

    // Store the review in the trainer's reviews column
    public function store(Request $request, $sessionId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Rating validation
            'review' => 'required|string|max:255', // Review text validation
        ]);

        $session = Session::findOrFail($sessionId);

        // Ensure the user is not the trainer of the session
        if ($session->trainer_id == Auth::id()) {
            return redirect()->route('sessions.index')->with('error', 'You cannot review your own session.');
        }

        // Get the trainer for this session
        $trainer = $session->trainer;

        // Add the new review
        $trainer->addReview($request->rating, $request->review);

        // Mark the session as reviewed (optional)
        $session->update(['has_reviewed' => true]);

        return redirect()->route('sessions.index')->with('success', 'Review added successfully.');
    }
}
