<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\FrequentQuestionCollection;
use App\Http\Resources\SupportAnswer as ResourcesSupportAnswer;
use App\Http\Resources\SupportThemeCollection;
use App\Http\Resources\SupportTicketCollection;
use App\Models\Support\FrequentQuestion;
use App\Models\Support\SupportAnswer;
use App\Models\Support\SupportTheme;
use App\Models\Support\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\QuestionHelper;

class SupportController extends ApiController
{
    protected $ticket;
    protected $answer;
    protected $question;
    protected $theme;

    public function __construct(SupportTicket $ticket, SupportAnswer $answer, FrequentQuestion $question, SupportTheme $theme)
    {
        $this->ticket   = $ticket;
        $this->answer   = $answer;
        $this->question = $question;
        $this->theme    = $theme;
    }

    public function store(Request $request){
        $ticket_number = str_pad(mt_rand(1, 99), 1, '0', STR_PAD_LEFT) . date("i") . str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT) . date("hsd");
        $request->validate([
            'description'       => 'required|string|min:5',
            'id_user'           => 'required|exists:users,id',
            'id_support_theme'  => 'required|exists:support_themes,id',
        ]);

        try {
            DB::beginTransaction();
            $this->ticket::create([
                'id' => $ticket_number,
                'ticket' => $ticket_number,
                'description' => $request->description,
                'id_user' => $request->id_user,
                'id_support_theme' => $request->id_support_theme,
            ]);
            DB::commit();
            return $this->showMessage('Mensaje Enviado, daremos respuesta a tu correo. Tu Numero de ticket es: '. $ticket_number. ' Guarda el numero para hacer seguimiento a tu caso.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    public function show($id){
        try {
            $answer = $this->answer::where('id_support_ticket',$id)->first();
            if ($answer) {
                return response()->json([
                    'ticket' => new ResourcesSupportAnswer($answer)
                ]);
            }
            return $this->showMessage('Este ticket no existe');

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }

    }

    public function findTicket($id){
        try {
            return response()->json([
                'ticket' => new SupportTicketCollection($this->ticket::where('id_user',$id)->get())
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    public function supporTheme(){
        return response()->json([
            'theme' => new SupportThemeCollection($this->theme::all())
        ]);
    }

    public function findFrequentQuestionWord($keyWord = null){
        return $this->__find_Frequent_Question($keyWord, null);
    }

    public function findFrequentQuestionTheme($theme = null){
        return $this->__find_Frequent_Question(null, $theme);
    }

    private function __find_Frequent_Question($keyWord = null, $theme = null){
        try {
            if($keyWord){
                $questions = $this->question::findQuestion($keyWord, null);
            }elseif($theme){
                $questions = $this->question::findQuestion(null, $theme);
            }
            if (!$questions->isEmpty()) {
                return response()->json([
                    'questions' => new FrequentQuestionCollection($questions)
                ]);
            }else{
                return $this->showMessage('No se encontro ningún resultado');
            }
            return $this->showMessage('Debe proporcionar una busqueda');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }
    }
}
