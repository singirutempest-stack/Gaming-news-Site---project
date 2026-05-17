<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $articles = News::all();

        foreach ($articles as $article) {
            foreach (['en', 'ru', 'kz'] as $locale) {
                Translation::updateOrCreate(
                    ['news_id' => $article->id, 'locale' => $locale],
                    [
                        'translated_title' => $this->title($article->title, $locale),
                        'translated_short_description' => $this->shortDescription($locale),
                        'translated_content' => $this->content($locale),
                    ]
                );
            }
        }
    }

    private function title(string $title, string $locale): string
    {
        $titles = [
            'Neon Arena Update Reworks Ranked Matchmaking' => [
                'ru' => 'Обновление Neon Arena переработало рейтинговый подбор',
                'kz' => 'Neon Arena жаңартуы рейтингтік матч таңдауды өзгертті',
            ],
            'Starfall Odyssey Gets a Cinematic Story Trailer' => [
                'ru' => 'Starfall Odyssey получила кинематографичный сюжетный трейлер',
                'kz' => 'Starfall Odyssey ойынына кинематографиялық сюжет трейлері шықты',
            ],
            'Cyber League Finals Set New Viewership Record' => [
                'ru' => 'Финал Cyber League установил новый рекорд просмотров',
                'kz' => 'Cyber League финалы көрілім бойынша жаңа рекорд орнатты',
            ],
            'Patch Notes: Balance Changes Shake Up the Meta' => [
                'ru' => 'Патч-ноуты: изменения баланса встряхнули мету',
                'kz' => 'Патч жазбалары: теңгерім өзгерістері метаны жаңартты',
            ],
            'Indie Showcase Reveals Ten New Console Launches' => [
                'ru' => 'Indie Showcase показал десять новых консольных релизов',
                'kz' => 'Indie Showcase он жаңа консоль релизін көрсетті',
            ],
            'How to Build a Strong Early Game Loadout' => [
                'ru' => 'Как собрать сильный набор для ранней игры',
                'kz' => 'Ойын басында мықты жабдықты қалай жинауға болады',
            ],
            'Studio Confirms Crossplay for Mech Frontier' => [
                'ru' => 'Студия подтвердила кроссплей для Mech Frontier',
                'kz' => 'Студия Mech Frontier үшін кроссплейді растады',
            ],
            'Review: Ashen Circuit Blends Speed and Strategy' => [
                'ru' => 'Обзор: Ashen Circuit сочетает скорость и стратегию',
                'kz' => 'Шолу: Ashen Circuit жылдамдық пен стратегияны біріктіреді',
            ],
            'Major Publisher Opens New European Studio' => [
                'ru' => 'Крупный издатель открыл новую европейскую студию',
                'kz' => 'Ірі баспагер Еуропада жаңа студия ашты',
            ],
            'Esports Teams Announce Spring Roster Moves' => [
                'ru' => 'Киберспортивные команды объявили весенние перестановки',
                'kz' => 'Киберспорт командалары көктемгі құрам өзгерістерін жариялады',
            ],
            'Trailer Breakdown: Mythforge Awakening' => [
                'ru' => 'Разбор трейлера: Mythforge Awakening',
                'kz' => 'Трейлер талдауы: Mythforge Awakening',
            ],
            'Beginner Guide: Resource Routes That Actually Work' => [
                'ru' => 'Гайд для новичков: маршруты ресурсов, которые работают',
                'kz' => 'Жаңадан бастаушыларға нұсқаулық: тиімді ресурс бағыттары',
            ],
            'Cloud Saves Arrive for Retro Vault Collection' => [
                'ru' => 'В Retro Vault Collection появились облачные сохранения',
                'kz' => 'Retro Vault Collection үшін бұлттық сақтау қосылды',
            ],
            'Review: Drift Kings 2 Finds Its Rhythm' => [
                'ru' => 'Обзор: Drift Kings 2 находит свой ритм',
                'kz' => 'Шолу: Drift Kings 2 өз ырғағын тапты',
            ],
            'Industry Report Shows PC Sales Rising Again' => [
                'ru' => 'Отчет индустрии показал новый рост продаж ПК',
                'kz' => 'Индустрия есебі ПК сатылымының қайта өскенін көрсетті',
            ],
            'Five Tips for Surviving Nightmare Mode' => [
                'ru' => 'Пять советов для выживания в режиме Nightmare',
                'kz' => 'Nightmare режимінде аман қалуға арналған бес кеңес',
            ],
            'Battle Royale Event Adds Limited Time Bosses' => [
                'ru' => 'Событие Battle Royale добавило временных боссов',
                'kz' => 'Battle Royale оқиғасы уақытша босс қосты',
            ],
            'Speedrun Community Crowns a New World Record' => [
                'ru' => 'Сообщество спидранеров зафиксировало новый мировой рекорд',
                'kz' => 'Спидран қауымдастығы жаңа әлемдік рекордты мойындады',
            ],
            'Console Update Improves Capture Tools' => [
                'ru' => 'Консольное обновление улучшило инструменты записи',
                'kz' => 'Консоль жаңартуы жазу құралдарын жақсартты',
            ],
            'Developer Q&A Teases Next Expansion' => [
                'ru' => 'Ответы разработчиков намекнули на следующее дополнение',
                'kz' => 'Әзірлеушілер сұхбаты келесі кеңейтімді меңзеді',
            ],
        ];

        return $titles[$title][$locale] ?? $title;
    }

    private function shortDescription(string $locale): string
    {
        return match ($locale) {
            'ru' => 'Свежие подробности, реакция игроков и тактический контекст одной из главных игровых новостей недели.',
            'kz' => 'Аптаның ең маңызды ойын жаңалықтарының бірі туралы жаңа деректер, ойыншылар пікірі және тактикалық талдау.',
            default => 'Fresh details, player reactions, and tactical context for one of the biggest gaming stories this week.',
        };
    }

    private function content(string $locale): string
    {
        return match ($locale) {
            'ru' => str_repeat('Игровая сцена быстро меняется, и эта статья объясняет, что изменилось, почему это важно и как сообщество реагирует на обновление. Разработчики выделили улучшения качества, доступность и соревновательный баланс, а игроки уже проверяют новые стратегии на живых серверах. ', 3),
            'kz' => str_repeat('Ойын әлемі жылдам өзгеріп жатыр, ал бұл мақала не өзгергенін, оның неге маңызды екенін және қауымдастықтың қалай қабылдағанын түсіндіреді. Әзірлеушілер сапаны жақсарту, қолжетімділік және жарыстық теңгерімге назар аударды, ал ойыншылар жаңа стратегияларды серверлерде сынап жатыр. ', 3),
            default => str_repeat('The gaming scene keeps moving fast, and this update gives players a clear look at what changed, why it matters, and how the community is reacting. Developers highlighted polish, accessibility, and competitive balance while players are already testing new strategies across live servers. ', 3),
        };
    }
}
