<div class="article-default-index">
    <div class="container">
        <!-- 文章列表 -->
        <div class="articles-default col-sm-12 col-md-9">
            <?php foreach ($posts as $kp => $post): ?>    
            <div class="panel panel-default">
                <div class="panel-body">
                    <!--             
                    /**
                     * 文章区
                     */
                    -->
                    <div class="article">
                        <!-- 标题-->
                        <div class="title"><?=$post['post_title']?></div>
                        <!-- 横幅广告 -->
                        <div class="banner">
                            <img src="" alt="banner" width="100%" height="120" class="img-rounded">
                        </div>
                        
                        <!-- 摘要 -->
                        <div class="excerpt"><?=$post['post_content']?></div>
                        <!-- 正文 -->
                        <div class="content">正文</div>
                    </div>
                    <!-- 
                    /**
                     * 评论区
                     */
                    -->
                    <div class="comments-default">
                        <!-- 评论循环开始 -->
                        <div class="comment">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <img src="" alt="头像" class="avatar img-rounded">
                                        </div>
                                        <div class="col-xs-10">
                                            这是评论正文
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 text-right">
                                        赞 踩 回复
                                    </div>
                                    </div>
                                    
                                    <!-- 回复 -->
                                    <!-- <div class="comment"></div> -->

                                </div>
                            </div>
                        </div>
                        <!-- 评论循环结束 -->
                        <!-- 评论分页 -->
                        <nav class="text-center">
                          <ul class="pagination">
                            <li>
                              <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                            </li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li>
                              <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                            </li>
                          </ul>
                        </nav>
                        <!-- 评论分页节结束 -->
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>



        <!-- 小组件 -->
        <div class="col-sm-12 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">小组件</div>
            </div>
        </div>

    </div>
    <!-- 文章列表分页 -->
    <!--<div class='text-center'>
        <nav>
          <ul class="pagination">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>-->
    <!-- 文章列表分页结束 -->
</div>
