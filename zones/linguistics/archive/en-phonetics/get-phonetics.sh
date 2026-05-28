#!/bin/bash

# -v verbose
# -s silent
# -H header
# -A user agent

user_agent='Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0'

prefix='http://l90463d4.beget.tech/chapter'

dir='p00'

cd ${dir}

# <h3>Фонетика</h3>

# <h4>Общие сведения</h4>

sleep 1; echo '01'; curl -s -A "${user_agent}" "${prefix}/Lesson_phonetics_alphabet.html"            -o 01.html # Английский алфавит
sleep 2; echo '02'; curl -s -A "${user_agent}" "${prefix}/Lesson_phonetics_transcription.html"       -o 02.html # Английская транскрипция
sleep 3; echo '03'; curl -s -A "${user_agent}" "${prefix}/Lesson_phonetics_sound.html"               -o 03.html # Английские звуки
sleep 5; echo '04'; curl -s -A "${user_agent}" "${prefix}/Lesson_phonetics.html"                     -o 04.html # Особенности английского произношения
sleep 2; echo '05'; curl -s -A "${user_agent}" "${prefix}/Lesson_phonetics_american.html"            -o 05.html # Американский английский

# <h4>Звуки английского языка</h4>

# <h5>Гласные</h5>

sleep 3; echo '06'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ʌ.html"                       -o 06.html # Звук [ ʌ ]
sleep 5; echo '07'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_æ.html"                       -o 07.html # Звук [ æ ]
sleep 2; echo '08'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_a.html"                       -o 08.html # Звук [ a: ]
sleep 6; echo '09'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ai.html"                      -o 09.html # Звук [ ai ]
sleep 3; echo '10'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_aʊ.html"                      -o 10.html # Звук [ aʊ ]
sleep 4; echo '11'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_aiə.html"                     -o 11.html # Звуки [ aiə, aʊə ]
sleep 1; echo '12'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_i.html"                       -o 12.html # Звук [ i ]
sleep 3; echo '13'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_i1.html"                      -o 13.html # Звук [ i: ]
sleep 5; echo '14'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_e.html"                       -o 14.html # Звук [ e ]
sleep 2; echo '15'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ei.html"                      -o 15.html # Звук [ ei ]
sleep 6; echo '16'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ə.html"                       -o 16.html # Звук [ ə ]
sleep 3; echo '17'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_iə.html"                      -o 17.html # Звук [ iə ]
sleep 4; echo '18'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ɜ.html"                       -o 18.html # Звук [ ɜ: ]
sleep 1; echo '19'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ɒ.html"                       -o 19.html # Звук [ ɒ ]
sleep 3; echo '20'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ɔ.html"                       -o 20.html # Звук [ ɔ: ]
sleep 1; echo '21'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ɔi.html"                      -o 21.html # Звук [ ɔi ]
sleep 3; echo '22'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_əʊ.html"                      -o 22.html # Звук [ əʊ ]
sleep 5; echo '23'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ʊ.html"                       -o 23.html # Звук [ ʊ ]
sleep 2; echo '24'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_u.html"                       -o 24.html # Звуки [ u:, ju: ]
sleep 6; echo '25'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ʊə.html"                      -o 25.html # Звуки [ ʊə, jʊə ]
sleep 2; echo '26'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_eə.html"                      -o 26.html # Звук [ eə ]

# <h5>Согласные</h5>

sleep 5; echo '27'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_p.html"                       -o 27.html # Звуки [ p, b, k, g, f, v, m ]
sleep 2; echo '28'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_n.html"                       -o 28.html # Звуки [ n, l, t, d ]
sleep 6; echo '29'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_s.html"                       -o 29.html # Звуки [ s, z ]
sleep 3; echo '30'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_0.html"                       -o 30.html # Звуки [ θ, ð ]
sleep 4; echo '31'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ŋ.html"                       -o 31.html # Звук [ ŋ ]
sleep 1; echo '32'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_r.html"                       -o 32.html # Звук [ r ]
sleep 3; echo '33'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_j.html"                       -o 33.html # Звук [ j ]
sleep 5; echo '34'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_t.html"                       -o 34.html # Звук [ tʃ ]
sleep 2; echo '35'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_d.html"                       -o 35.html # Звук [ dʒ ]
sleep 6; echo '36'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_h.html"                       -o 36.html # Звук [ h ]
sleep 3; echo '37'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_ʃ.html"                       -o 37.html # Звуки [ ʃ, ʒ ]
sleep 4; echo '38'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_w.html"                       -o 38.html # Звук [ w ]
sleep 1; echo '39'; curl -s -A "${user_agent}" "${prefix}/Lesson_sound_wɜ.html"                      -o 39.html # Звукосочетание [ wɜ: ]

# <h4>Особенности английского произношения</h4>

sleep 3; echo '40'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_readingClose.html"   -o 40.html # Чтение гласных букв в закрытом и открытом типе слога
sleep 5; echo '41'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_reading34.html"      -o 41.html # Чтение гласных в третьем и четвёртом типе слога
sleep 2; echo '42'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_assimilation.html"   -o 42.html # Ассимиляция : альвеолярные [ s, z, n, t ] становятся зубными перед [ θ, ð ]
sleep 6; echo '43'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_side.html"           -o 43.html # Боковой взрыв: сочетание звуков [ t, d ] cо звуком [ l ]
sleep 3; echo '44'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_nose.html"           -o 44.html # Носовой взрыв: сочетание звуков [ t, d ] cо звуком [ n ]
sleep 4; echo '45'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_lost.html"           -o 45.html # Потеря взрыва
sleep 1; echo '46'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_division.html"       -o 46.html # Деление предложений на смысловые отрезки

# <h4>Ударение</h4>

sleep 1; echo '47'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_word.html"           -o 47.html # Словесное ударение
sleep 3; echo '48'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_change.html"         -o 48.html # Изменение места словесного ударения
sleep 5; echo '49'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_prefix.html"         -o 49.html # Ударение в словах с отделяемыми приставками
sleep 2; echo '50'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_compound.html"       -o 50.html # Ударение в составных словах
sleep 6; echo '51'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_phrase.html"         -o 51.html # Фразовое ударение
sleep 3; echo '52'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_logic.html"          -o 52.html # Логическое ударение
sleep 4; echo '53'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_rhythm.html"         -o 53.html # Ритмические группы
sleep 1; echo '54'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_underRhythm.html"    -o 54.html # Изменение словесного ударения под влиянием ритма

# <h4>Интонация</h4>

sleep 5; echo '55'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_intonation.html"     -o 55.html # Английская интонация
sleep 2; echo '56'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_downTone.html"       -o 56.html # Нисходящий тон
sleep 6; echo '57'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_upTone.html"         -o 57.html # Восходящий тон
sleep 3; echo '58'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronunciations_downUpTone.html"     -o 58.html # Нисходяще-восходящий тон


# <h3>Лексика</h3>

# <h4>Словообразование</h4>

sleep 3; echo '59'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_1.html"                  -o 59.html # Образование слов без изменения произношения и написания
sleep 5; echo '60'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_2.html"                  -o 60.html # Образование слов при помощи изменения места ударения и чередования звуков
sleep 2; echo '61'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_3.html"                  -o 61.html # Словообразование при помощи приставок
sleep 6; echo '62'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_4.html"                  -o 62.html # Суффиксы существительных
sleep 3; echo '63'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_5.html"                  -o 63.html # Суффиксы глаголов
sleep 4; echo '64'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_6.html"                  -o 64.html # Суффиксы прилагательных и наречий
sleep 1; echo '65'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_7.html"                  -o 65.html # Составные существительные, прилагательные, местоимения, глаголы и наречия

# <h4>Особенности лексики</h4>

sleep 5; echo '66'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_8.html"                  -o 66.html # Фразовые глаголы
sleep 2; echo '67'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_9.html"                  -o 67.html # Проблемные слова
sleep 6; echo '68'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_10.html"                 -o 68.html # Вводные слова и обороты
sleep 3; echo '69'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_11.html"                 -o 69.html # Как обратиться к незнакомому человеку?
sleep 4; echo '70'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_12.html"                 -o 70.html # Страны, национальности и языки</section>
