function likePost(post, type)  {
    $.ajax({
        url: 'include/likePost.php',
        type: 'post',
        data: {
            "post": post,
            "type": type
        },
    });
}