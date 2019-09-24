<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use mikehaertl\pdftk\Pdf;

class PrintController extends Controller
{
  public function printHtml(Request $request)
  {
    $doc_name = $request->input('doc_name');
    $form_type = $request->input('form_type');
    if (Storage::exists($doc_name)) {
      Storage::delete($doc_name);
    }
    $pdfData =  $request->input('pdf_data');

    $file_name = pathinfo($doc_name, PATHINFO_BASENAME);
    $template_path = 'templates\\'.$form_type.'.pdf';
    $pdf = new Pdf(resource_path($template_path),
    ['command'=>str_replace('"','',config('xpdftk.binary')),'useExec' => true]);
    //['form1[0].#subform[0].PtAILine1_ANumber[0]'=>'A-374808106378833','TextField1.val1'=>'123-232-23']
            
    if($pdf->flatten()            
      ->fillForm($pdfData)
      ->needAppearances()
      ->execute())
    {
      $doc_file = file_get_contents( (string) $pdf->getTmpFile() );
      Storage::put($doc_name, $doc_file);      
      return json()->success('Created');
    }
    else{
      return json()->success($pdf->getError());
    }
    
  }

  public function download(Request $request)
  {
    $doc_name = $request->input('doc_name');
    $file_name = pathinfo($doc_name, PATHINFO_BASENAME);
    $contents = Storage::get($doc_name);
    return new Response(
      $contents,
      200,
      array(
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => "attachment; filename=$file_name"
      )
    );
  }

  public function test()
  {
    $html = '<div style="border: 1px solid black; width: 1100px; height: 1480px;">I love you!</div>';
    $pdf = \PDF::loadHTML($html);
    $pdf->setPaper('letter')
      ->setOrientation('portrait')
      ->setOptions([
        'margin-top' => 8,
        'margin-right' => 13,
        'margin-bottom' => 0,
        'margin-left' => 11,
      ]);

    return $pdf->download('test.pdf');
  }

  public function hello() 
  {
    return "Hello world!";
  }
}
