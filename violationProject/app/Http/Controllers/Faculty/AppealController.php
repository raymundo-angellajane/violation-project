<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function index() // para magpakita ung listahan ng mga appeals
    {
        $this->checkFaculty(); // ma-ensure na faculty ang user

        $appeals = Appeal::with('studentAppeals.student')->get();

        return view('faculty.appeals.index', [
            'appeals' => $appeals, // listahan ng appeals
            'faculty' => session('user_name'), // pangalan ng faculty na naka-login
        ]);
    }

    public function review($id) // para mag-review ng specific appeal
    {
        $this->checkFaculty();

        $appeal = Appeal::with('studentAppeals.student', 'studentAppeals.violation')
            ->findOrFail($id);

        return view('faculty.appeals.review', [
            'appeal'  => $appeal, // specific appeal na nire-review
            'faculty' => session('user_name'),
        ]);
    }

    public function update(Request $request, $id) // para i-update ang status ng appeal pagkatapos ng review
    {
        $this->checkFaculty(); // ensure na faculty ang user

        $request->validate([
            'status' => 'required|in:Approved,Rejected', // syempre dapat valid ang status
        ]);

        $appeal = Appeal::with('studentAppeals.violation')->findOrFail($id); // hanapin ang appeal. bakit findOrFail? kasi kung wala, mag-404 siya

        foreach ($appeal->studentAppeals as $sa) { // loop sa bawat student appeal
            $sa->update([ // update ang bawat student appeal
                'status'      => $request->status,
                'reviewed_by' => session('user_id'), // dito ilalagay yung faculty ID na nag-review
                'reviewed_at' => now(),
            ]);

            if ($sa->violation) {
                $sa->violation->update([
                    'status' => $request->status === 'Approved' ? 'Cleared' : 'Disclosed',
                ]);
            }
        }

        return redirect()->route('faculty.appeals.index')
            ->with('success', 'Appeal reviewed successfully.'); // redirect pabalik sa listahan ng appeals na may success message
    }

    public function approve($id) // para i-approve ang appeal at i-clear ang violation
    {
        $this->checkFaculty();

        $appeal = Appeal::with('studentAppeals.violation')->findOrFail($id);

        foreach ($appeal->studentAppeals as $sa) {
            $sa->update([
                'status'      => 'Approved',
                'reviewed_by' => session('user_id'),
                'reviewed_at' => now(),
            ]);

            if ($sa->violation) {
                $sa->violation->update(['status' => 'Cleared']);
            }
        }

        $appeal->update(['status' => 'Approved']); // update ang status ng appeal mismo

        return redirect()->back()->with('success', 'Appeal approved and violation cleared.');
    }

    private function checkFaculty() // para ma-check kung faculty ang user ulit
    {
        if (!session('user_id') || session('user_role') !== 'faculty') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as faculty.',
            ]);
        }
    }
}
