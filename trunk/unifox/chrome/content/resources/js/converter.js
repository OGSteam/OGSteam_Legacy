var uf_days = new Array('Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam');
var uf_months = new Array('Jan', 'F\u00E9v', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Ao\u00DB', 'Sep', 'Oct', 'Nov', 'D\u00E9c');
function uf_relativeDate(time) {
date = new Date;
date.setTime(time);

	date_now = new Date;
	//date_now.setTime(date_now.getTime());
	
	var hour = date.getHours();
	var min = date.getMinutes();
	var sec = date.getSeconds();
	var day_number = date.getDate();
	var day_number_now = date_now.getDate();
	var month = date.getMonth();
	var month_now = date_now.getMonth();
	var nextday = "";
	
	if (day_number_now != day_number || month_now != month) {
		nextday = uf_days[date.getDay()] + ' ' + day_number + ' ' + uf_months[date.getMonth()] + ' ';
	}
	if (sec < 10) sec = '0' + sec;
	if (min < 10) min = '0' + min;
	if (hour < 10) hour = '0' + hour;

	var datetime =  nextday + hour + ':' + min + ':' + sec;
	//alert(datetime);
	return datetime;
}
function convertir()
{
var rc;
var coef;
var now=new Date();
var prod;
var speed;
rc=document.getElementsByName("r1")[0].value;
c2=document.getElementsByName("c2")[0].value;
speed=document.getElementsByName("c3")[0].value;
coef=transfo();
prod=Math.round(rc/coef);
if(rc<=c2*1000000*speed)document.getElementById("r2").innerHTML='<font color="lime">'+prod+'</font>';

else document.getElementById("r2").innerHTML='<font color="red">'+c2*1000000*speed+' max</font>';
var seconds=time(coef);
var s=seconds;
//alert("seconds"+seconds);
var enddate=new Date();
enddate.setTime(now.getTime()+seconds*1000);
//alert(enddate);
try{
var str=uf_relativeDate(enddate);
}catch(e){alert(e)}
//alert('str'+str);
var hours=Math.floor(seconds/3600);
seconds-=hours*3600;
var minutes=Math.floor(seconds/60);
seconds-=minutes*60;
if(minutes<10)minutes="0"+minutes;

if(seconds<10)seconds="0"+seconds;
document.getElementById("tps").innerHTML='<font color="lime">'+hours+'h'+minutes+'min'+seconds+' s</font><br/>'+
	'<font color="yellow">'+/*s+' '+now+' '+enddate+' '+*/str+'</font>';
}
//convertir();