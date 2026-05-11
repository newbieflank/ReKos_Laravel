<?php

namespace App\Services;

class ContentFilterService
{
    /**
     * Daftar kata-kata jorok / vulgar / kasar (Bahasa Indonesia).
     */
    protected array $kataJorok = [
        // Kata kasar umum
        'anjing', 'anjg', 'anjir', 'anjrit', 'anj', 'ajg', 'ajig',
        'bangsat', 'bgst', 'bngst',
        'babi', 'babi lu', 'babik',
        'kontol', 'kntl', 'kontl', 'konthol',
        'memek', 'mmk', 'memk', 'meki',
        'ngentot', 'ngewe', 'entot', 'ngntot', 'ngentod',
        'pepek', 'ppk',
        'jancok', 'jancuk', 'dancok', 'jncok', 'cok', 'jnck',
        'asu', 'asw',
        'goblok', 'gblk', 'goblog',
        'tolol', 'tll',
        'idiot',
        'bego', 'bgo', 'begok',
        'kampret', 'kmprt',
        'setan', 'setan lu',
        'iblis',
        'monyet', 'monyong',
        'tai', 'taik', 'tahi',
        'peler', 'pelir',
        'titit', 'tytyd', 'tityd',
        'itil',
        'tempik',
        'pantat', 'pantek', 'pntat',
        'bokong',
        'kimak',
        'pukimak', 'puki',
        'lonte', 'lonthe',
        'sundal', 'sundel',
        'lacur',
        'pelacur',
        'jablay',
        'perek',
        'brengsek', 'brngsk', 'brengsk',
        'keparat',
        'sialan', 'sial',
        'bodoh', 'bdoh',
        'dungu',
        'berak',
        'kentut',
        'bajingan', 'bjngn',
        'kunyuk',
        'sontoloyo',
        'ndasmu',
        'matamu',
        'diamput', 'diancuk',
        'cukimai', 'cukimay',
        'pukimai', 'pukimay',
        'laso',
        'sompret',
        'geblek', 'gblk',
        'edan', 'edian',
        'celeng',
        'kirik',
        'cocot',
        'bacot', 'bacod', 'bct',
        'ngaceng',
        'colmek', 'coli', 'col',
        'bokep', 'bokef',
    ];

  
    protected array $kataJudol = [
      
        'judi', 'judol', 'judi online',
        'slot', 'slot gacor', 'slot online', 'slotgacor',
        'togel', 'tgel', 'togell',
        'casino', 'kasino',
        'poker', 'pokerr',
        'jackpot', 'jp', 'jackpott',
        'scatter', 'scater',
        'maxwin', 'max win',
        'gacor', 'gacorr',
        'rtp', 'rtp live',
        'bandar', 'bandarq',
        'taruhan', 'tarhan',
        'betting', 'bet',
        'sportsbook',
        'live casino',
        'baccarat', 'bakarat',
        'roulette', 'rolet',
        'sicbo',
        'domino', 'dominoqq', 'domino99',
        'capsa',
        'ceme',
        'gaple',
        'tembak ikan',
        'fish hunter',
        'pragmatic', 'pragmatik',
        'habanero',
        'joker123', 'joker gaming',
        'pg soft', 'pgsoft',
        'spadegaming',
        'microgaming',
        'sbobet',
        'ibcbet',
        'maxbet',
        'cmd368',
        'w88',
        'm88',
        'fun88',
        '188bet',
        'daftar slot',
        'link slot',
        'situs slot',
        'agen slot',
        'agen judi',
        'bandar togel',
        'prediksi togel',
        'bocoran slot',
        'pola slot',
        'deposit pulsa',
        'deposit dana',
        'withdraw',
        'freebet', 'free bet',
        'bonus new member',
        'bonus deposit',
        'turnover',
        'depo', 'wd',
        'zeus', 'gates of olympus', 'sweet bonanza',
        'starlight princess',
        'koi gate',
        'mahjong ways',
        'wild west gold',
        'aztec gems',
    ];

  
    protected array $kataAsusila = [
       
        'porn', 'porno', 'pornografi',
        'xxx', 'xxxx',
        'sex', 'seks', 'seksual',
        'ml', 'making love',
        'onlyfans', 'only fans',
        'nude', 'nudes', 'telanjang', 'bugil', 'bugilk',
        'striptease', 'strip',
        'orgasme', 'orgasm',
        'masturbasi', 'onani',
        'fetish', 'fetis',
        'bdsm',
        'hentai', 'ecchi',
        'doujin', 'doujinshi',
        'jav',
        'milf',
        'threesome', '3some',
        'gangbang',
        'blowjob', 'bj',
        'handjob', 'hj',
        'oral sex',
        'anal',
        'dildo', 'vibrator',
        'kondom',
        'esek', 'esek-esek',
        'mesum', 'cabul',
        'zina',
        'selingkuh',
        'psk',
        'wts',
        'open bo', 'openbo', 'open be o',
        'bo', 
        'stw',
        'tante girang',
        'tante hot',
        'abg hot',
        'semprot', 'semprotku',
        'lendir',
        'desah', 'desahan',
        'ngecrot', 'crot', 'crotz',
        'ewe', 'ewe ewe',
        'birahi',
        'syahwat',
        'nafsu',
        'rangsang', 'merangsang',
        'vulgar',
        'pikiran kotor',
        'video panas',
        'film panas',
        'foto hot',
        'live hot',
        'cam girl',
        'camgirl',
        'sugar daddy', 'sugardaddy',
        'sugar baby', 'sugarbaby',
        'escort',
        'massage plus',
        'pijat plus',
        'plus plus', 'plusplus',
    ];


    public function check(string $text): array
    {
        $normalizedText = $this->normalizeText($text);

        $found = [];

        // Cek kata jorok
        foreach ($this->kataJorok as $kata) {
            if ($this->containsWord($normalizedText, $kata)) {
                $found[] = [
                    'word' => $kata,
                    'category' => 'kata_kasar',
                    'label' => 'Kata Kasar/Jorok',
                ];
                break; 
            }
        }

        // Cek kata judol
        foreach ($this->kataJudol as $kata) {
            if ($this->containsWord($normalizedText, $kata)) {
                $found[] = [
                    'word' => $kata,
                    'category' => 'judol',
                    'label' => 'Judi Online (Judol)',
                ];
                break;
            }
        }

       
        foreach ($this->kataAsusila as $kata) {
            if ($this->containsWord($normalizedText, $kata)) {
                $found[] = [
                    'word' => $kata,
                    'category' => 'asusila',
                    'label' => 'Konten Asusila',
                ];
                break;
            }
        }

        return [
            'is_clean' => empty($found),
            'violations' => $found,
            'message' => empty($found)
                ? null
                : 'Ulasan mengandung konten yang tidak diperbolehkan: ' . implode(', ', array_map(fn($f) => $f['label'], $found)),
        ];
    }

    
    protected function normalizeText(string $text): string
    {
        $text = mb_strtolower($text);

       
        $text = preg_replace('/(.)\1{2,}/', '$1$1', $text);

  
        $replacements = [
            '0' => 'o',
            '1' => 'i',
            '3' => 'e',
            '4' => 'a',
            '5' => 's',
            '6' => 'g',
            '7' => 't',
            '8' => 'b',
            '9' => 'g',
            '@' => 'a',
            '$' => 's',
            '!' => 'i',
            '+' => 't',
        ];

        $text = str_replace(array_keys($replacements), array_values($replacements), $text);

        
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);

        $text = preg_replace('/\s+/', ' ', trim($text));

        return $text;
    }

   
    protected function containsWord(string $text, string $word): bool
    {
        $word = preg_quote($word, '/');

       
        return (bool) preg_match('/\b' . $word . '\b/', $text);
    }

    
    public function getClientKeywords(): array
    {
        return [
            'kata_kasar' => $this->kataJorok,
            'judol' => $this->kataJudol,
            'asusila' => $this->kataAsusila,
        ];
    }
}
