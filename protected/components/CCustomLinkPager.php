<?php
class CCustomLinkPager extends CLinkPager
{
	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo $this->header;
		echo CHtml::tag('div',$this->htmlOptions,implode("\n",$buttons));
		echo $this->footer;
	}

	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		//$buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false,'pagination__link pagination__link--arrow');

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false,'pagination__link pagination__link--arrow');

		// last page
		//$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);

		return $buttons;
	}

	protected function createPageButton($label,$page,$class,$hidden,$selected,$other_class='pagination__link')
	{
		if($selected)
			$other_class.=' '.$this->selectedPageCssClass;
		if($hidden)
			$class.=' '.$this->hiddenPageCssClass;
		return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page), array('class'=>$other_class)).'</li>';
	}
}