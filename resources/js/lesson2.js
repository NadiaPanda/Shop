// сравнения

console.log(2>5)

let x =10
let y =5 
let res = x>y //сразу записывайте в переменную результат сравнения

console.log ('x==10', x==10)

let a = 'a'
let b = 'b'

console.log ('b>a', b>a)

let str1 ='abc'
let str2 ='abbb'

console.log('srt1>str2', str1>str2)

console.log("'1'==1", '1'==1)
console.log("'1'===1", '1'===1)

let variable ='0'
let variable1 = 0 // строка с '0' true, число 0 будет false

console.log(Bollean(variable), Bollean(variable1))


console.log('null> 0', null> 0) //false
console.log('null== 0', null== 0) //false
console.log('null >= 0', null >= 0) //true

//console.log(Number(null)) //0
//console.log(Number(undefined)) //NaN

console.log('undefined> 0', undefined> 0) //false
console.log('undefined== 0', undefined== 0) //false
console.log('undefined >= 0', undefined >= 0) //false

//условные конструкции

let answer = prompt('Какой сейчас год?')

if (answer == 2022) {
    alert ('Правильно!')
} else if (answer < 2022) {
    alert ('Больше!')
} else {
    alert ('Вы что, из будущего?')
}

let age = 28
let access = age > 18? 'доступ есть' : 'доступа нет'

console.log ('access', access)

// && ||
let haveLicence = true
let number1 = 123
let string1 = ''
res = number1 || string1 || haveLicence ///123

//string1 ||number1 ||  haveLicence ///123 если нигде нет true, тогда вернется последнее, которое проверялось




if (res) {
    console.log ('yes')
} else {
    console.log ('no')
}

res = string1 && number1 && haveLicence //ищет первое ложное значение и возвращается его изначальне значение
if (res) {
    console.log ('yes')
} else {
    console.log ('no')
}
console.log(res) 

// циклы
let i = 0
while (i < 10) {
    console.log(i++)
}

let j = 0
for(let j =0; j < 5; j++) {
    if (j == 2) {
        break //continue 2 не выведится
    }
    console.log (j)
} 
console.log('j',j)