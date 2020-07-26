<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Mail\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class CommonController extends Controller
{
    public function loadCities(Request $request){
        return response()->json(DB::table('cities')->where('state_id', $request->id)->get());
    }

    public function addAddress(Request $request){

    }

    public function contact(){
        return view('pages.front.contact');
    }

    public function about(){
        return view('pages.front.about');
    }


    public function updateProfile(ProfileUpdateRequest $request){
        $validated = $request->validated();
        Auth::user()->fill($validated)->save();
        return back()->with('status', 'Profile updated');
    }

    public function changePassword(ChangePasswordRequest $request){
        Auth::user()->update([
            'password' => bcrypt(request('password'))
        ]);
        return back()->with('status', 'Password updated');
    }

    public function productRequest(Request $request){
        $this->sendMail($request->input('email'));
//        $status = Mail::to($request->input('email'))->send(new ProductRequest($request->input('product'),$request->input('message'),$request->input('email')));
        return response()->json(['message'=>'Message sent']);
    }

    public function sendMail(string $email){
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = config('mail.host');                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = config('mail.username');                     // SMTP username
            $mail->Password   = config('mail.password');                              // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
