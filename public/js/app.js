
$(document).ready(function(){
    
    data = $('#twitterContainer').data();
    
    if(false==data.hasTweets){
        $.ajax({
            url:'/twitter/electro-swing',
            success:loadTweets
        });
    }
});

function loadTweets(response){
    html = '';
    
    if(response.statuses.length>0){
        for(i=0;i<response.statuses.length;i++){
            html+=makeTweet(response.statuses[i]);
        }
    }
    
    $('#twitterContainer').html(html);
}

function makeTweet(tweet){
    html = '';
    html+='<div class="tweet" data-id="'+tweet.id_str+'">';
    html+='<div class="tweet-text">'+tweet.text+'</div>';
    html+='</div>';
    
    return html;
}
