jQuery(function ($) {
    $('.makeSearch').click(function(){
        search();
    });

    $('.loadSubjects').click(function(){
        var data = {
            action: 'loadSubjects',
            data: JSON.stringify(window.XL_row_object),
        };
        $.post('admin-ajax.php', data, function(data){
            if(data.success){
                alert('Загружено');
            }else{
                alert('Не загружено');
            }
        });
    });

    function search() {
        $("#my_file_output").empty();
        var array_of_items = JSON.parse(window.XL_row_object);
        var user_goods = window.arr;

        var array_of_success = []; //прошло все предметы абитуриента
        var array_of_info = {}; //прошло все предметы абитуриента
        var newString = '';
        var secondString = '';
        array_of_items.forEach(element => {
            newString = '';
            secondString = '';
            if (array_of_info[element['Id']]) {
                if (typeof array_of_info[element['Id']].Subjects === 'string') {
                    array_of_info[element['Id']].Subjects = [array_of_info[element['Id']].Subjects, element.Subjects.substring(3)];
                } else {
                    newString = element.Subjects.substring(3);
                    // узнаем есть ли спец символ, в нашем случае "/"
                    if (element.Subjects.indexOf('/') > -1) {
                        // берем предмет до "/"
                        secondString = newString.substring(newString.indexOf('/') + 1, newString.length);

                        // берем предмет после "/"
                        newString = newString.substring(0, newString.indexOf('/'));

                        // добавляем в массив предметов "предмет"
                        array_of_info[element['Id']].Subjects.push([newString, secondString]);
                    } else {
                        // если нет "/", добавляем в массив предметов "предмет"
                        array_of_info[element['Id']].Subjects.push(newString);
                    }
                }
            } else {
                array_of_info[element['Id']] = element;
                if (typeof array_of_info[element['Id']].Subjects === 'string')
                    array_of_info[element['Id']].Subjects = array_of_info[element['Id']].Subjects.substring(3);
            }
        });
        // Object.keys(array_of_info).map(function (key) {
        //     array_of_info[key].Subjects = array_of_info[key].Subjects.filter(onlyUnique);
        // });

        Object.keys(array_of_info).map(function (key) {
            var all_items = 0; // если в конце совпадает с числом нужных предметов то добавляем в список
            array_of_info[key].Subjects.forEach(good => {
                if (Array.isArray(good)) {
                    var oneOfTwo = false
                    good.forEach(item => {
                        if (user_goods.indexOf(item) >= 0) {
                            oneOfTwo = true;
                        }
                    });
                    if (oneOfTwo) {
                        all_items++
                    }
                } else {
                    if (user_goods.indexOf(good) >= 0) {
                        all_items++;
                    }
                }
            });
            if (all_items == array_of_info[key].Subjects.length) {
                array_of_success.push(array_of_info[key]);
            }
        });

        console.log(array_of_success);
        console.log('array_of_success');
        array_of_success.map(function (GOOD, index) {
            $("#my_file_output").append("<ul id='ul_" + GOOD.Id + "'></ul>");
            var output = new Array();
            output.push('Facultet --- ' + GOOD['Facultet']);
            output.push('Код та назва спеціальності (спеціалізації) --- ' + GOOD['Код та назва спеціальності (спеціалізації)']);
            output.push('Назва освітньої програми --- ' + GOOD['Назва освітньої програми']);
            output.push('Тип конкурсної пропозиції --- ' + GOOD['Тип конкурсної пропозиції']);
            GOOD['Subjects'].map(function (item, index) {
                if (typeof item === 'string') {
                    output.push(index + ". " + item);
                } else {
                    var str = '';
                    item.map(function (i, index) {
                        str += i + ' або ';
                    });
                    output.push(index + ". " + str.substr(0, str.length - 4));
                }

            })
            $(document).ready(function () {
                var list = "";
                for (i = 0; i < output.length; i++) {
                    list += "<li>" + output[i] + "</li>";
                }
                $("#ul_" + GOOD.Id).append(list);

            });
        });
    }
});