var editing = 0;
var lastudpdate;
var editingnote=-1;
function updateidhead(el)
{
    editingnote = el.id.substr(3);
}
function updateident(el)
{
    editingnote = el.id.substr(5);
}


function updatenote(){
    // $('#lastupdated'+editingnote).html('Saving...');
    var headi = document.getElementById("inp"+editingnote).value;
    var ent = document.getElementById("entry"+editingnote).value;
    $.get( "updatenote.php", {pass: app_pass, id: editingnote, heading: headi, entry: ent, now: (new Date().getTime()/1000)-new Date().getTimezoneOffset()*60})
    .done(function(data) {
        if(data=='1')
        {
            editing = 0;
            $('#lastupdated'+editingnote).html('Last Saved Today');
        }
        else
        {
            $('#lastupdated'+editingnote).html(data);
        }
    });
    $('#newnotes').hide().show(0);
}

function newnote(){
    $.get( "insertnew.php", {pass: app_pass, now: (new Date().getTime()/1000)-new Date().getTimezoneOffset()*60})
    .done(function(data) {
        if(data=='1') 
        {
            $(window).scrollTop(0);
            location.reload(true);
        }
        else alert(data);
    });
}

function save(){
    alert('saved');
}

function checkedit(){
    if(editingnote==-1) return ;

    var curdate = new Date();
    var curtime = curdate.getTime();
    if(editing==1 && curtime-lastudpdate > 1000)
    {
        updatenote();
    }
}

function deletePermanent(iid){
    var r = confirm("Are you sure you want to permanently delete the note "+document.getElementById("inp"+iid).value+"?. This action can't be undone.");
    if (r == true) {
        $.get( "permanentDelete.php", {pass: app_pass, id:iid})
        .done(function(data) {
            if(data=='1') $('#note'+iid).hide();
            else alert(data);
        });
    }
}

function putBack(iid){
    $.get( "putback.php", {pass: app_pass, id:iid})
    .done(function(data) {
        if(data=='1') $('#note'+iid).hide();
        else alert(data);
    });
}

function deleteNote(iid){
    var r = confirm("Are you sure you want to delete the note "+document.getElementById("inp"+iid).value+"?");
    if (r == true) {
        $.get( "deletenote.php", {pass: app_pass, id:iid})
        .done(function(data) {
            if(data=='1') $('#note'+iid).hide();
            else alert(data);
        });
    }
}

function update(){
    editing = 1;
    var curdate = new Date();
    var curtime = curdate.getTime();
    lastudpdate = curtime;
    // alert(lastudpdate);
    $('#lastupdated'+editingnote).html('Saving...');
}
$('body').on( 'keyup', 'textarea', function (){
    $(this).height(0);
    $(this).height(this.scrollHeight);
    $(this).blur();
    $(this).focus();
    update();
});


$('body').on( 'keyup', 'input', function (){
    update();
});

function h1(e) {
    $(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight);
}
$('textarea').each(function () {
  h1(this);
});

$( document ).ready(function() {
    setInterval(function(){ checkedit(); }, 1000);
});
