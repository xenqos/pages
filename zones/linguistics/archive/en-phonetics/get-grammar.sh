#!/bin/bash

# -v verbose
# -s silent
# -H header
# -A user agent

user_agent='Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0'

prefix='http://l90463d4.beget.tech/chapter'

dir='g00'

cd ${dir}

# <h3>Грамматика</h3>

# <h4>Части речи</h4>

# <h5>Артикли</h5>

sleep 1; echo '01'; curl -s -A "${user_agent}" "${prefix}/Lesson_article_classes.html"               -o 01.html # Определение, происхождение
sleep 2; echo '02'; curl -s -A "${user_agent}" "${prefix}/Lesson_article_defined.html"               -o 02.html # Определенный артикль
sleep 6; echo '03'; curl -s -A "${user_agent}" "${prefix}/Lesson_article_notdefined.html"            -o 03.html # Неопределенный артикль
sleep 3; echo '04'; curl -s -A "${user_agent}" "${prefix}/Lesson_article_absence.html"               -o 04.html # Отсутствие артикля
sleep 4; echo '05'; curl -s -A "${user_agent}" "${prefix}/Lesson_article_place.html"                 -o 05.html # Место в предложении

# <h5>Существительное</h5>

sleep 1; echo '06'; curl -s -A "${user_agent}" "${prefix}/Lesson_noun_classes.html"                  -o 06.html # Определение, классификация
sleep 3; echo '07'; curl -s -A "${user_agent}" "${prefix}/Lesson_noun_race.html"                     -o 07.html # Род
sleep 5; echo '08'; curl -s -A "${user_agent}" "${prefix}/Lesson_noun_plural.html"                   -o 08.html # Множественное число
sleep 2; echo '09'; curl -s -A "${user_agent}" "${prefix}/Lesson_noun_deaths.html"                   -o 09.html # Падеж
sleep 6; echo '10'; curl -s -A "${user_agent}" "${prefix}/Lesson_noun_determinants.html"             -o 10.html # Определители
sleep 3; echo '11'; curl -s -A "${user_agent}" "${prefix}/Lesson_noun_function.html"                 -o 11.html # Функции в предложении
sleep 4; echo '12'; curl -s -A "${user_agent}" "${prefix}/Lesson_noun_collective.html"               -o 12.html # Собирательные существительные

# <h5>Местоимение</h5>

sleep 1; echo '13'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_classes.html"               -o 13.html # Определение, структура, употребление
sleep 3; echo '14'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_personal.html"              -o 14.html # Личные
sleep 5; echo '15'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_possessive.html"            -o 15.html # Притяжательные
sleep 2; echo '16'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_pointing.html"              -o 16.html # Указательные
sleep 6; echo '17'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_return.html"                -o 17.html # Возвратные
sleep 3; echo '18'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_mutual.html"                -o 18.html # Взаимные
sleep 4; echo '19'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_question.htm"               -o 19.html # Вопросительные
sleep 3; echo '20'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_relative.html"              -o 20.html # Относительные
sleep 5; echo '21'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_undefined.html"             -o 21.html # Неопределенные
sleep 2; echo '22'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_negative.html"              -o 22.html # Отрицательные
sleep 6; echo '23'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_separation.html"            -o 23.html # Разделительные
sleep 3; echo '24'; curl -s -A "${user_agent}" "${prefix}/Lesson_pronoun_universal.html"             -o 24.html # Универсальные

# <h5>Прилагательное</h5>

sleep 2; echo '25'; curl -s -A "${user_agent}" "${prefix}/Lesson_adjective_classes.html"             -o 25.html # Определение, строение, вид
sleep 6; echo '26'; curl -s -A "${user_agent}" "${prefix}/Lesson_adjective_degree.html"              -o 26.html # Степени сравнения прилагательных
sleep 3; echo '27'; curl -s -A "${user_agent}" "${prefix}/Lesson_adjective_substantiation.html"      -o 27.html # Субстантивация
sleep 4; echo '28'; curl -s -A "${user_agent}" "${prefix}/Lesson_adjective_order.html"               -o 28.html # Порядок прилагательных
sleep 3; echo '29'; curl -s -A "${user_agent}" "${prefix}/Lesson_adjective_function.html"            -o 29.html # Функции в предложении

# <h5>Числительные</h5>

sleep 3; echo '30'; curl -s -A "${user_agent}" "${prefix}/Lesson_numerals_definition.html"           -o 30.html # Определение
sleep 5; echo '31'; curl -s -A "${user_agent}" "${prefix}/Lesson_numerals_quantitative.html"         -o 31.html # Количественные
sleep 2; echo '32'; curl -s -A "${user_agent}" "${prefix}/Lesson_numerals_ordinal.html"              -o 32.html # Порядковые
sleep 6; echo '33'; curl -s -A "${user_agent}" "${prefix}/Lesson_numerals_date.html"                 -o 33.html # Даты и время
sleep 3; echo '34'; curl -s -A "${user_agent}" "${prefix}/Lesson_numerals_fractional.html"           -o 34.html # Дробные числа
sleep 4; echo '35'; curl -s -A "${user_agent}" "${prefix}/Lesson_numerals_substantiation.html"       -o 35.html # Субстантивация

# <h5>Глаголы</h5>
sleep 3; echo '36'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_class.html"                    -o 36.html # Классификация английских глаголов
sleep 5; echo '37'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_modal.html"                    -o 37.html # Модальные глаголы
sleep 2; echo '38'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_right_wrong.html"              -o 38.html # Правильные и неправильные глаголы
sleep 6; echo '39'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_right_wrong_table.html"        -o 39.html # Таблица неправильных глаголов
sleep 3; echo '40'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_face_number.html"              -o 40.html # Лицо и число английского глагола
sleep 4; echo '41'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_transition.html"               -o 41.html # Переходные и непереходные глаголы
sleep 3; echo '42'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_to_be.html"                    -o 42.html # Глагол to be
sleep 5; echo '43'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_to_be.html"                    -o 43.html # Глагол to have
sleep 2; echo '44'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_personal.html"                 -o 44.html # Личные и неличные формы глагола
sleep 6; echo '45'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_Infinitive.html"               -o 45.html # Инфинитив
sleep 3; echo '46'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_Gerundium.html"                -o 46.html # Герундий
sleep 4; echo '47'; curl -s -A "${user_agent}" "${prefix}/Lesson_verb_Sacrament.html"                -o 47.html # Причастие

# <h6>Времена</h6>


# <h5>Настоящее</h5>
sleep 3; echo '48'; curl -s -A "${user_agent}" "${prefix}/Lesson_present_simple.html"                -o 48.html # Present Simple
sleep 4; echo '49'; curl -s -A "${user_agent}" "${prefix}/Lesson_present_continuous.html"            -o 49.html # Present Continuous
sleep 3; echo '50'; curl -s -A "${user_agent}" "${prefix}/Lesson_present_perfect.html"               -o 50.html # Present Perfect
sleep 5; echo '51'; curl -s -A "${user_agent}" "${prefix}/Lesson_present_perfect_continuous.html"    -o 51.html # Present Perfect Continuous


# <h5>Прошедшее</h5>
sleep 2; echo '52'; curl -s -A "${user_agent}" "${prefix}/Lesson_past_simple.html"                   -o 52.html # Past Simple
sleep 6; echo '53'; curl -s -A "${user_agent}" "${prefix}/Lesson_past_continuous.html"               -o 53.html # Past Continuous
sleep 3; echo '54'; curl -s -A "${user_agent}" "${prefix}/Lesson_past_perfect.html"                  -o 54.html # Past Perfect
sleep 4; echo '55'; curl -s -A "${user_agent}" "${prefix}/Lesson_past_perfect_continuous.html"       -o 55.html # Past Perfect Continuous


# <h5>Будующее</h5>
sleep 2; echo '56'; curl -s -A "${user_agent}" "${prefix}/Lesson_future_simple.html"                 -o 56.html # Future Simple
sleep 6; echo '57'; curl -s -A "${user_agent}" "${prefix}/Lesson_future_continuous.html"             -o 57.html # Future Continuous
sleep 3; echo '58'; curl -s -A "${user_agent}" "${prefix}/Lesson_future_perfect.html"                -o 58.html # Future Perfect
sleep 4; echo '59'; curl -s -A "${user_agent}" "${prefix}/Lesson_future_perfect_continuous.html"     -o 59.html # Future Perfect Continuous

# <h5>Наречие</h5>

sleep 3; echo '60'; curl -s -A "${user_agent}" "${prefix}/Lesson_adverb_definition.html"             -o 60.html # Определение, употребление
sleep 5; echo '61'; curl -s -A "${user_agent}" "${prefix}/Lesson_adverb_time.html"                   -o 61.html # Наречия времени
sleep 2; echo '62'; curl -s -A "${user_agent}" "${prefix}/Lesson_adverb_place.html"                  -o 62.html # Наречия места
sleep 6; echo '63'; curl -s -A "${user_agent}" "${prefix}/Lesson_adverb_action.html"                 -o 63.html # Наречия образа действия
sleep 3; echo '64'; curl -s -A "${user_agent}" "${prefix}/Lesson_adverb_degree.html"                 -o 64.html # Наречия меры и степени
sleep 4; echo '65'; curl -s -A "${user_agent}" "${prefix}/Lesson_adverb_comparison.html"             -o 65.html # Степени сравнения наречий
sleep 3; echo '66'; curl -s -A "${user_agent}" "${prefix}/Lesson_adverb_fromAdjective.html"          -o 66.html # Как отличить наречие от прилагательного
sleep 5; echo '67'; curl -s -A "${user_agent}" "${prefix}/Lesson_adverb_placeInDialog.html"          -o 67.html # Место наречия в предложении

# <h5>Предлог</h5>

sleep 2; echo '68'; curl -s -A "${user_agent}" "${prefix}/Lesson_proposal_definition.html"           -o 68.html # Определение и форма
sleep 6; echo '69'; curl -s -A "${user_agent}" "${prefix}/Lesson_proposal_table.html"                -o 69.html # Полный список английских предлогов
sleep 3; echo '70'; curl -s -A "${user_agent}" "${prefix}/Lesson_proposal_gramma.html"               -o 70.html # Грамматическое значение предлогов
sleep 4; echo '71'; curl -s -A "${user_agent}" "${prefix}/Lesson_proposal_logic.html"                -o 71.html # Смысловое значение предлогов
sleep 3; echo '72'; curl -s -A "${user_agent}" "${prefix}/Lesson_proposal_place.html"                -o 72.html # Место предлога в предложении


# <h5>Союз</h5>

sleep 6; echo '73'; curl -s -A "${user_agent}" "${prefix}/Lesson_union_classes.html"                 -o 73.html # Определение, классификация
sleep 3; echo '74'; curl -s -A "${user_agent}" "${prefix}/Lesson_union_composing.html"               -o 74.html # Сочинительные союзы
sleep 4; echo '75'; curl -s -A "${user_agent}" "${prefix}/Lesson_union_subordinative.html"           -o 75.html # Подчинительные союзы
sleep 3; echo '76'; curl -s -A "${user_agent}" "${prefix}/Lesson_union_word.html"                    -o 76.html # Союзные слова
sleep 5; echo '77'; curl -s -A "${user_agent}" "${prefix}/Lesson_union_fromAdverb.html"              -o 77.html # Как отличить союз от предлога или наречия

# <h5>Частица</h5>

sleep 4; echo '78'; curl -s -A "${user_agent}" "${prefix}/Lesson_particle_class.html"                -o 78.html # Определение, классификация, употребление
sleep 3; echo '79'; curl -s -A "${user_agent}" "${prefix}/Lesson_particle_fromOther.html"            -o 79.html # Как отличить частицу от других частей речи

# <h5>Косвенная речь</h5>

sleep 3; echo '80'; curl -s -A "${user_agent}" "${prefix}/Lesson_indirect_forming.html"              -o 80.html # Образование и употребление
sleep 4; echo '81'; curl -s -A "${user_agent}" "${prefix}/Lesson_indirect_matching.html"             -o 81.html # Согласование времен

# <h5>Пунктуация в английском языке</h5>

sleep 2; echo '82'; curl -s -A "${user_agent}" "${prefix}/Lesson_punctuation_sign.html"             -o 82.html # Знаки препинания


# <h3>Лексика</h3>

# <h4>Словообразование</h4>

sleep 5; echo '83'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_1.html"                 -o 83.html # Образование слов без изменения произношения и написания
sleep 2; echo '84'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_2.html"                 -o 84.html # Образование слов при помощи изменения места ударения и чередования звуков
sleep 6; echo '85'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_3.html"                 -o 85.html # Словообразование при помощи приставок
sleep 3; echo '86'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_4.html"                 -o 86.html # Суффиксы существительных
sleep 4; echo '87'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_5.html"                 -o 87.html # Суффиксы глаголов
sleep 1; echo '88'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_6.html"                 -o 88.html # Суффиксы прилагательных и наречий
sleep 3; echo '89'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_7.html"                 -o 89.html # Составные существительные, прилагательные, местоимения, глаголы и наречия

# <h4>Особенности лексики</h4>

sleep 5; echo '90'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_8.html"                 -o 90.html # Фразовые глаголы
sleep 2; echo '91'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_9.html"                 -o 91.html # Проблемные слова
sleep 6; echo '92'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_10.html"                -o 92.html # Вводные слова и обороты
sleep 3; echo '93'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_11.html"                -o 93.html # Как обратиться к незнакомому человеку?
sleep 4; echo '94'; curl -s -A "${user_agent}" "${prefix}/Lesson_vocabulary_12.html"                -o 94.html # Страны, национальности и языки</section>
