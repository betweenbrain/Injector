<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    3/17/14 10:13 AM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

$params = json_decode($item->params);
$view = JRequest::getWord('view');
K2HelperUtilities::setDefaultImage($item, $view);
?>
<div id="k2Container" class="itemView<?php echo ($item->featured) ? ' itemIsFeatured' : ''; ?>">

<div class="itemHeader">

		<span class="itemDateCreated">
			<?php echo JHTML::_('date', $item->created, JText::_('K2_DATE_FORMAT_LC2')); ?>
		</span>

	<h2 class="itemTitle">
		<?php echo $item->title; ?>

		<?php if ($item->featured): ?>
			<!-- Featured flag -->
			<span>
		  	<sup>
			    <?php echo JText::_('K2_FEATURED'); ?>
		    </sup>
	  	</span>
		<?php endif; ?>

	</h2>
</div>

<div class="itemBody">

	<?php if (!empty($item->image)): ?>
		<!-- Item Image -->
		<div class="itemImageBlock">
		  <span class="itemImage">
		  	<a class="modal" rel="{handler: 'image'}" href="<?php echo $item->imageXLarge; ?>" title="<?php echo JText::_('K2_CLICK_TO_PREVIEW_IMAGE'); ?>">
			    <img src="<?php echo $item->image; ?>" alt="<?php if (!empty($item->image_caption))
			    {
				    echo K2HelperUtilities::cleanHtml($item->image_caption);
			    }
			    else
			    {
				    echo K2HelperUtilities::cleanHtml($item->title);
			    } ?>" style="width:<?php echo $item->imageWidth; ?>px; height:auto;" />
		    </a>
		  </span>

			<?php if (!empty($item->params->itemImageMainCaption) && !empty($item->image_caption)): ?>
				<!-- Image caption -->
				<span class="itemImageCaption"><?php echo $item->image_caption; ?></span>
			<?php endif; ?>

			<?php if (!empty($item->params->itemImageMainCredits) && !empty($item->image_credits)): ?>
				<!-- Image credits -->
				<span class="itemImageCredits"><?php echo $item->image_credits; ?></span>
			<?php endif; ?>

		</div>
	<?php endif; ?>

	<?php if (!empty($item->fulltext)): ?>
		<?php if (!empty($item->params->itemIntroText)): ?>
			<!-- Item introtext -->
			<div class="itemIntroText">
				<?php echo $item->introtext; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($item->params->itemFullText)): ?>
			<!-- Item fulltext -->
			<div class="itemFullText">
				<?php echo $item->fulltext; ?>
			</div>
		<?php endif; ?>
	<?php else: ?>
		<!-- Item text -->
		<div class="itemFullText">
			<?php echo $item->introtext; ?>
		</div>
	<?php endif; ?>



	<?php if (count($item->extra_fields)): ?>
		<!-- Item extra fields -->
		<div class="itemExtraFields">
			<h3><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h3>
			<ul>
				<?php foreach ($item->extra_fields as $key => $extraField): ?>
					<?php if ($extraField->value != ''): ?>
						<li class="<?php echo ($key % 2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
							<?php if ($extraField->type == 'header'): ?>
								<h4 class="itemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
							<?php else: ?>
								<span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?>:</span>
								<span class="itemExtraFieldsValue"><?php echo $extraField->value; ?></span>
							<?php endif; ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>

		</div>
	<?php endif; ?>

	<?php if (intval($item->modified) != 0): ?>
		<div class="itemContentFooter">

			<?php //die('<pre>' . print_r($item, true) . '</pre>') ?>

			<?php if (!empty($item->params->itemHits)): ?>
				<!-- Item Hits -->
				<span class="itemHits">
				<?php echo JText::_('K2_READ'); ?> <b><?php echo $item->hits; ?></b> <?php echo JText::_('K2_TIMES'); ?>
			</span>
			<?php endif; ?>

			<?php if (!empty($item->params->itemDateModified) && intval($item->modified) != 0): ?>
				<!-- Item date modified -->
				<span class="itemDateModified">
				<?php echo JText::_('K2_LAST_MODIFIED_ON'); ?> <?php echo JHTML::_('date', $item->modified, JText::_('K2_DATE_FORMAT_LC2')); ?>
			</span>
			<?php endif; ?>

		</div>
	<?php endif; ?>

</div>

<?php if (!empty($item->params->itemTwitterButton) || !empty($item->params->itemFacebookButton) || !empty($item->params->itemGooglePlusOneButton)) : ?>
	<!-- Social sharing -->
	<div class="itemSocialSharing">

		<?php if (!empty($item->params->itemTwitterButton)): ?>
			<!-- Twitter Button -->
			<div class="itemTwitterButton">
				<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal"<?php if (!empty($item->params->twitterUsername)) : ?> data-via="<?php echo $item->params->twitterUsername; ?>"<?php endif; ?>>
					<?php echo JText::_('K2_TWEET'); ?>
				</a>
				<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
			</div>
		<?php endif; ?>

		<?php if (!empty($item->params->itemFacebookButton)): ?>
			<!-- Facebook Button -->
			<div class="itemFacebookButton">
				<div id="fb-root"></div>
				<script type="text/javascript">
					(function (d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s);
						js.id = id;
						js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
				</script>
				<div class="fb-like" data-send="false" data-width="200" data-show-faces="true"></div>
			</div>
		<?php endif; ?>

		<?php if (!empty($item->params->itemGooglePlusOneButton)): ?>
			<!-- Google +1 Button -->
			<div class="itemGooglePlusOneButton">
				<g:plusone annotation="inline" width="120"></g:plusone>
				<script type="text/javascript">
					(function () {
						window.___gcfg = {lang: 'en'}; // Define button default language here
						var po = document.createElement('script');
						po.type = 'text/javascript';
						po.async = true;
						po.src = 'https://apis.google.com/js/plusone.js';
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(po, s);
					})();
				</script>
			</div>
		<?php endif; ?>

	</div>
<?php endif; ?>

<?php if (!empty($item->params->itemCategory) || !empty($item->params->itemTags) || !empty($item->params->itemAttachments)): ?>
	<div class="itemLinks">

		<?php if (!empty($item->params->itemCategory)): ?>
			<!-- Item category -->
			<div class="itemCategory">
				<span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
				<a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a>
			</div>
		<?php endif; ?>

		<?php if (!empty($item->params->itemTags) && count($item->tags)): ?>
			<!-- Item tags -->
			<div class="itemTagsBlock">
				<span><?php echo JText::_('K2_TAGGED_UNDER'); ?></span>
				<ul class="itemTags">
					<?php foreach ($item->tags as $tag): ?>
						<li><a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a></li>
					<?php endforeach; ?>
				</ul>

			</div>
		<?php endif; ?>

		<?php if (!empty($item->params->itemAttachments) && count($item->attachments)): ?>
			<!-- Item attachments -->
			<div class="itemAttachmentsBlock">
				<span><?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></span>
				<ul class="itemAttachments">
					<?php foreach ($item->attachments as $attachment): ?>
						<li>
							<a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
							<?php if (!empty($item->params->itemAttachmentsCounter)): ?>
								<span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits == 1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

	</div>
<?php endif; ?>

<?php if (!empty($item->params->itemAuthorBlock) && empty($item->created_by_alias)): ?>
	<!-- Author Block -->
	<div class="itemAuthorBlock">

		<?php if (!empty($item->params->itemAuthorImage) && !empty($item->author->avatar)): ?>
			<img class="itemAuthorAvatar" src="<?php echo $item->author->avatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->author->name); ?>" />
		<?php endif; ?>

		<div class="itemAuthorDetails">
			<h3 class="itemAuthorName">
				<a rel="author" href="<?php echo $item->author->link; ?>"><?php echo $item->author->name; ?></a>
			</h3>

			<?php if (!empty($item->params->itemAuthorDescription) && !empty($item->author->profile->description)): ?>
				<p><?php echo $item->author->profile->description; ?></p>
			<?php endif; ?>

			<?php if (!empty($item->params->itemAuthorURL) && !empty($item->author->profile->url)): ?>
				<span class="itemAuthorUrl"><?php echo JText::_('K2_WEBSITE'); ?>
					<a rel="me" href="<?php echo $item->author->profile->url; ?>" target="_blank"><?php echo str_replace('http://', '', $item->author->profile->url); ?></a></span>
			<?php endif; ?>

			<?php if (!empty($item->params->itemAuthorEmail)): ?>
				<span class="itemAuthorEmail"><?php echo JText::_('K2_EMAIL'); ?> <?php echo JHTML::_('Email.cloak', $item->author->email); ?></span>
			<?php endif; ?>



			<!-- K2 Plugins: K2UserDisplay -->
			<?php echo $item->event->K2UserDisplay; ?>

		</div>

	</div>
<?php endif; ?>

<?php if (!empty($item->params->itemAuthorLatest) && empty($item->created_by_alias) && isset($this->authorLatestItems)): ?>
	<!-- Latest items from author -->
	<div class="itemAuthorLatest">
		<h3><?php echo JText::_('K2_LATEST_FROM'); ?> <?php echo $item->author->name; ?></h3>
		<ul>
			<?php foreach ($this->authorLatestItems as $key => $item): ?>
				<li class="<?php echo ($key % 2) ? "odd" : "even"; ?>">
					<a href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>

	</div>
<?php endif; ?>

<?php
/*
Note regarding 'Related Items'!
If you add:
- the CSS rule 'overflow-x:scroll;' in the element div.itemRelated {…} in the k2.css
- the class 'k2Scroller' to the ul element below
- the classes 'k2ScrollerElement' and 'k2EqualHeights' to the li element inside the foreach loop below
- the style attribute 'style="width:<?php echo $item->imageWidth; ?>px;"' to the li element inside the foreach loop below
...then your Related Items will be transformed into a vertical-scrolling block, inside which, all items have the same height (equal column heights). This can be very useful if you want to show your related articles or products with title/author/category/image etc., which would take a significant amount of space in the classic list-style display.
*/
?>

<?php if (!empty($item->params->itemRelated) && isset($this->relatedItems)): ?>
	<!-- Related items by tag -->
	<div class="itemRelated">
		<h3><?php echo JText::_("K2_RELATED_ITEMS_BY_TAG"); ?></h3>
		<ul>
			<?php foreach ($this->relatedItems as $key => $item): ?>
				<li class="<?php echo ($key % 2) ? "odd" : "even"; ?>">

					<?php if (!empty($item->params->itemRelatedTitle)): ?>
						<a class="itemRelTitle" href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
					<?php endif; ?>

					<?php if (!empty($item->params->itemRelatedCategory)): ?>
						<div class="itemRelCat"><?php echo JText::_("K2_IN"); ?>
							<a href="<?php echo $item->category->link ?>"><?php echo $item->category->name; ?></a></div>
					<?php endif; ?>

					<?php if (!empty($item->params->itemRelatedAuthor)): ?>
						<div class="itemRelAuthor"><?php echo JText::_("K2_BY"); ?>
							<a rel="author" href="<?php echo $item->author->link; ?>"><?php echo $item->author->name; ?></a>
						</div>
					<?php endif; ?>

					<?php if (!empty($item->params->itemRelatedImageSize)): ?>
						<img style="width:<?php echo $item->imageWidth; ?>px;height:auto;" class="itemRelImg" src="<?php echo $item->image; ?>" alt="<?php K2HelperUtilities::cleanHtml($item->title); ?>" />
					<?php endif; ?>

					<?php if (!empty($item->params->itemRelatedIntrotext)): ?>
						<div class="itemRelIntrotext"><?php echo $item->introtext; ?></div>
					<?php endif; ?>

					<?php if (!empty($item->params->itemRelatedFulltext)): ?>
						<div class="itemRelFulltext"><?php echo $item->fulltext; ?></div>
					<?php endif; ?>

					<?php if (!empty($item->params->itemRelatedMedia)): ?>
						<?php if ($item->videoType == 'embedded'): ?>
							<div class="itemRelMediaEmbedded"><?php echo $item->video; ?></div>
						<?php else: ?>
							<div class="itemRelMedia"><?php echo $item->video; ?></div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if (!empty($item->params->itemRelatedImageGallery)): ?>
						<div class="itemRelImageGallery"><?php echo $item->gallery; ?></div>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
			<li class="clr"></li>
		</ul>

	</div>
<?php endif; ?>



<?php if (!empty($item->params->itemVideo) && !empty($item->video)): ?>
	<!-- Item video -->
	<a name="itemVideoAnchor" id="itemVideoAnchor"></a>

	<div class="itemVideoBlock">
		<h3><?php echo JText::_('K2_MEDIA'); ?></h3>

		<?php if ($item->videoType == 'embedded'): ?>
			<div class="itemVideoEmbedded">
				<?php echo $item->video; ?>
			</div>
		<?php else: ?>
			<span class="itemVideo"><?php echo $item->video; ?></span>
		<?php endif; ?>

		<?php if (!empty($item->params->itemVideoCaption) && !empty($item->video_caption)): ?>
			<span class="itemVideoCaption"><?php echo $item->video_caption; ?></span>
		<?php endif; ?>

		<?php if (!empty($item->params->itemVideoCredits) && !empty($item->video_credits)): ?>
			<span class="itemVideoCredits"><?php echo $item->video_credits; ?></span>
		<?php endif; ?>

	</div>
<?php endif; ?>

<?php if (!empty($item->params->itemImageGallery) && !empty($item->gallery)): ?>
	<!-- Item image gallery -->
	<a name="itemImageGalleryAnchor" id="itemImageGalleryAnchor"></a>
	<div class="itemImageGallery">
		<h3><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h3>
		<?php echo $item->gallery; ?>
	</div>
<?php endif; ?>

<?php if (!empty($item->params->itemNavigation) && !JRequest::getCmd('print') && (isset($item->nextLink) || isset($item->previousLink))): ?>
	<!-- Item navigation -->
	<div class="itemNavigation">
		<span class="itemNavigationTitle"><?php echo JText::_('K2_MORE_IN_THIS_CATEGORY'); ?></span>

		<?php if (isset($item->previousLink)): ?>
			<a class="itemPrevious" href="<?php echo $item->previousLink; ?>">
				&laquo; <?php echo $item->previousTitle; ?>
			</a>
		<?php endif; ?>

		<?php if (isset($item->nextLink)): ?>
			<a class="itemNext" href="<?php echo $item->nextLink; ?>">
				<?php echo $item->nextTitle; ?> &raquo;
			</a>
		<?php endif; ?>

	</div>
<?php endif; ?>

<?php if (!empty($item->params->itemComments) && (($item->params->comments == '2' && !$this->user->guest) || ($item->params->comments == '1'))): ?>
	<!-- K2 Plugins: K2CommentsBlock -->
	<?php echo $item->event->K2CommentsBlock; ?>
<?php endif; ?>

<?php if (!empty($item->params->itemComments) && ($item->params->comments == '1' || ($item->params->comments == '2')) && empty($item->event->K2CommentsBlock)): ?>
	<!-- Item comments -->
	<a name="itemCommentsAnchor" id="itemCommentsAnchor"></a>

	<div class="itemComments">

		<?php if ($item->params->commentsFormPosition == 'above' && !empty($item->params->itemComments) && !JRequest::getInt('print') && ($item->params->comments == '1' || ($item->params->comments == '2' && K2HelperPermissions::canAddComment($item->catid)))): ?>
			<!-- Item comments form -->
			<div class="itemCommentsForm">
				<?php echo $this->loadTemplate('comments_form'); ?>
			</div>
		<?php endif; ?>

		<?php if ($item->numOfComments > 0 && !empty($item->params->itemComments) && ($item->params->comments == '1' || ($item->params->comments == '2'))): ?>
			<!-- Item user comments -->
			<h3 class="itemCommentsCounter">
				<span><?php echo $item->numOfComments; ?></span> <?php echo ($item->numOfComments > 1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
			</h3>
			<ul class="itemCommentsList">
				<?php foreach ($item->comments as $key => $comment): ?>
					<li class="<?php echo ($key % 2) ? "odd" : "even";
					echo (!$item->created_by_alias && $comment->userID == $item->created_by) ? " authorResponse" : "";
					echo ($comment->published) ? '' : ' unpublishedComment'; ?>">
	    	<span class="commentLink">
		    	<a href="<?php echo $item->link; ?>#comment<?php echo $comment->id; ?>" name="comment<?php echo $comment->id; ?>" id="comment<?php echo $comment->id; ?>">
				    <?php echo JText::_('K2_COMMENT_LINK'); ?>
			    </a>
		    </span>
						<?php if ($comment->userImage): ?>
							<img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" width="<?php echo !empty($item->params->commenterImgWidth); ?>" />
						<?php endif; ?>

						<span class="commentDate">
		    	<?php echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?>
		    </span>
		    <span class="commentAuthorName">
			    <?php echo JText::_('K2_POSTED_BY'); ?>
			    <?php if (!empty($comment->userLink)): ?>
				    <a href="<?php echo JFilterOutput::cleanText($comment->userLink); ?>" title="<?php echo JFilterOutput::cleanText($comment->userName); ?>" target="_blank" rel="nofollow">
					    <?php echo $comment->userName; ?>
				    </a>
			    <?php else: ?>
				    <?php echo $comment->userName; ?>
			    <?php endif; ?>
		    </span>
						<p><?php echo $comment->commentText; ?></p>

						<?php if ($this->inlineCommentsModeration || ($comment->published && ($this->params->get('commentsReporting') == '1' || ($this->params->get('commentsReporting') == '2' && !$this->user->guest)))): ?>
							<span class="commentToolbar">
					<?php if ($this->inlineCommentsModeration): ?>
						<?php if (!$comment->published): ?>
							<a class="commentApproveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=publish&commentID=' . $comment->id . '&format=raw') ?>"><?php echo JText::_('K2_APPROVE') ?></a>
						<?php endif; ?>


						<a class="commentRemoveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=remove&commentID=' . $comment->id . '&format=raw') ?>"><?php echo JText::_('K2_REMOVE') ?></a>
					<?php endif; ?>
								<?php if ($comment->published && ($this->params->get('commentsReporting') == '1' || ($this->params->get('commentsReporting') == '2' && !$this->user->guest))): ?>
									<a class="modal" rel="{handler:'iframe',size:{x:560,y:480}}" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=report&commentID=' . $comment->id) ?>"><?php echo JText::_('K2_REPORT') ?></a>
								<?php endif; ?>

								<?php if ($comment->reportUserLink): ?>
									<a class="k2ReportUserButton" href="<?php echo $comment->reportUserLink; ?>"><?php echo JText::_('K2_FLAG_AS_SPAMMER'); ?></a>
								<?php endif; ?>

				</span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>

		<?php endif; ?>

	</div>
<?php endif; ?>
</div>