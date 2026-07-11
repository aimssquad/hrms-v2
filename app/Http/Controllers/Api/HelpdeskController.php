<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Helpdesk;
use App\Helpers\Api\Helper;
use Illuminate\Http\Request;
use DB;
use Mail;

class HelpdeskController extends Controller
{
    public function helpdeskStore(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $emid = auth()->user()->emid;
            $employee_id = auth()->user()->employee_id;

            $org_name = DB::table('registration')->where('reg',$emid)->select('com_name')->first();
            
            $orgShort = strtoupper(substr($org_name->com_name, 0, 3));   // First 3 letters
            $randomNum = rand(10000, 99999);                       // Random 5 digits

            $ticket_no = $orgShort . $randomNum;
            //dd($ticket_no);

            $request->validate([
                "name"    => "required|string|max:255",
                "email"   => "required|email",
                "message" => "required|string",
                "image"   => "nullable|image|mimes:jpg,jpeg,png|max:2048",
            ]);

            // Handle image upload
            $imagePath = "";
            if ($request->hasFile("image")) {
                $imagePath = $request->file("image")->store("helpdesk", "public");
            }

             

            // Insert into helpdesk table
            $ticketData = [
                "ticket_no"   => $ticket_no,
                "name"        => $request->name,
                "email"       => $request->email,
                "message"     => $request->message,
                "image"       => $imagePath,
                "employee_id" => $employee_id,
                "emid"        => $emid,
                "status"      => 0,
                "created_at"  => now(),
            ];

            Helpdesk::insert($ticketData);

            

            //dd($org_name);

            // Mail::send('email-template.helpdesk_ticket', [
            //     "organization"   => $org_name,
            //     "employee_name"  => $request->name,
            //     "email"          => $request->email,
            //     "message"        => $request->message,
            //     "image"          => $imagePath ? asset('storage/' . $imagePath) : null,
            // ], function ($mail) {
            //     $mail->to("support@company.com")
            //         ->subject("New Helpdesk Ticket Submitted");
            // });


            return Helper::rjd("Ticket submitted successfully", 1, $ticketData);

        } catch (\Exception $e) {
            return Helper::rj("Server Error: " . $e->getMessage(), 500);
        }
    }

}
