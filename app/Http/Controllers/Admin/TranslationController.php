<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationController extends Controller
{
    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'target_lang' => 'required|string|size:2',
            'source_lang' => 'nullable|string|size:2',
        ]);

        $tr = new GoogleTranslate();
        $tr->setSource($request->source_lang ?? 'th');
        $tr->setTarget($request->target_lang);

        try {
            $translated = $tr->translate($request->text);
            return response()->json(['translation' => $translated]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Translation failed: ' . $e->getMessage()], 500);
        }
    }
}
