<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingPage;
use App\Models\VideoScript;
use App\Models\Testimonial;
use App\Models\AffiliateScript;
use App\Models\AdsImage;

class ToolController extends Controller
{
    public function landingPage()
    {
        return view('tools.landing-page');
    }

    public function storeLandingPage(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'target_audience' => 'required|string',
            'key_benefits' => 'required|string',
        ]);

        LandingPage::create($validated);

        return redirect()->back()->with('success', 'Landing Page berhasil disimpan!');
    }

    public function videoPrompter()
    {
        return view('tools.video-prompter');
    }

    public function storeVideoScript(Request $request)
    {
        $validated = $request->validate([
            'script_content' => 'required|string',
        ]);

        VideoScript::create([
            'title' => 'Untitled Script ' . date('Y-m-d H:i'),
            'script_content' => $validated['script_content'],
            'settings' => json_encode(['speed' => 5, 'font_size' => 32]), // Default settings
        ]);

        return redirect()->back()->with('success', 'Skrip video berhasil disimpan!')->with('script_content', $validated['script_content']);
    }

    public function waTestimonial()
    {
        return view('tools.wa-testimonial');
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'time' => 'required|string',
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'message' => $validated['message'],
            'image_path' => 'default.jpg', // Placeholder
        ]);

        return redirect()->back()->with('success', 'Testimoni berhasil disimpan!');
    }

    public function affiliateScript()
    {
        return view('tools.affiliate-script');
    }

    public function storeAffiliateScript(Request $request)
    {
        $validated = $request->validate([
            'product_link' => 'required|url',
            'platform' => 'required|string',
            'benefits' => 'required|string',
            'tone' => 'required|string',
        ]);

        $benefitsList = array_map('trim', explode(',', $validated['benefits']));
        $script = "Here is your " . $validated['platform'] . " script:\n\n";
        $script .= "Tone: " . $validated['tone'] . "\n\n";
        
        // Templates for "Sweet words"
        $openers = [
            "Gak nyangka banget nemu produk sekeren ini!",
            "Sumpah kalian wajib tau produk ini!",
            "Ini dia rahasia yang bikin aku happy seharian!",
            "Akhirnya nemu juga produk yang selama ini aku cari!"
        ];

        $connectors = [
            "Yang bikin aku makin cinta, ",
            "Gak cuma itu aja, ",
            "Terus yang paling aku suka, ",
            "Bayangin deh, "
        ];

        $closers = [
            "Cuss langsung cek keranjang kuning/link di bio ya! 🔥",
            "Jangan sampe kehabisan, checkout sekarang juga! 🛒",
            "Mumpung masih promo, buruan serbu! ⚡",
            "Tag temen kamu yang butuh ini juga! 👇"
        ];

        if ($validated['platform'] == 'TikTok' || $validated['platform'] == 'Instagram Reels') {
            $script .= "🎥 **VIDEO CONCEPT**\n";
            $script .= "Hook Visual: Tunjukkan produk dengan ekspresi " . ($validated['tone'] == 'Hype & Semangat' ? 'heboh/kaget' : 'tersenyum puas') . ".\n";
            $script .= "Text Overlay: \"" . $benefitsList[0] . "?? 😱\"\n\n";
            
            $script .= "🗣️ **CAPTION / SCRIPT**\n";
            $script .= $openers[array_rand($openers)] . " ";
            
            foreach ($benefitsList as $index => $benefit) {
                if ($index == 0) {
                    $script .= "Bayangin, " . $benefit . " lho! ";
                } else {
                    $connector = $connectors[array_rand($connectors)];
                    $script .= $connector . $benefit . ". ";
                }
            }
            
            $script .= "\n\n" . $closers[array_rand($closers)] . " #racunshopee #rekomendasi";

        } else {
            // Twitter / X
            $script .= $openers[array_rand($openers)] . "\n\n";
            
            foreach ($benefitsList as $benefit) {
                $script .= "✅ " . ucfirst($benefit) . "\n";
            }
            
            $script .= "\nAsli ini worth it banget. " . $connectors[array_rand($connectors)] . "harganya juga oke.\n";
            $script .= "Cek detailnya disini ya: " . $validated['product_link'];
        }

        AffiliateScript::create([
            'product_link' => $validated['product_link'],
            'platform' => $validated['platform'],
            'benefits' => $validated['benefits'],
            'tone' => $validated['tone'],
            'generated_script' => $script,
        ]);

        return redirect()->back()->with('success', 'Script afiliasi berhasil disimpan!')->with('generated_script', $script);
    }

    public function adsImage()
    {
        return view('tools.ads-image');
    }

    public function storeAdsImage(Request $request)
    {
        $validated = $request->validate([
            'headline' => 'required|string|max:255',
            'subheadline' => 'nullable|string|max:255',
            'cta' => 'required|string|max:255',
        ]);

        AdsImage::create([
            'headline' => $validated['headline'],
            'subheadline' => $validated['subheadline'],
            'cta' => $validated['cta'],
            'image_path' => 'default_ad.jpg', // Placeholder
        ]);

        return redirect()->back()->with('success', 'Desain iklan berhasil disimpan!');
    }
}
