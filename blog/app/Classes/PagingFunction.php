<?php
namespace App\Classes;

Class PagingFunction
{
	var $pageSize = 10;
	var $blockSize = 5;
	
	public function __construct($option = false) {
		if($option != null) {
			$this->pageSize = !empty($option['pageSize'])?$option['pageSize']:$this->pageSize;
			$this->blockSize = !empty($option['blockSize'])?$option['blockSize']:$this->blockSize;
		}
	}
	
	//총 리스트 수, 현재 페이지, 지정할 블럭 크기, 지정할 페이지 수, 1페이지 일 시 페이지 수 표시, 화살표 이동시 1페이지/블럭이동, 처음으로/끝으로 표시유무, 뒤로가기/다음으로 가기 표시유무, 페이지 버튼 모양, 뒤로가기 버튼 모양, 다음으로 버튼 모양, 처음으로 버튼 모양, 끝으로 버튼 모양    
	function vue_paging($totalCount, $thisPage, $link, $blockSize=false, $pageSize=false, $minShow=false, $block=false, $firstEnd=false, $showFast=false, $numBtn=false, $prevBtn=false, $nextBtn=false, $firstBtn=false, $endBtn=false)
	{	
		if($blockSize == false || $blockSize == '') {
			$blockSize = 5;
		}
        if($pageSize == false || $pageSize == '') {
            $pageSize = 3;
        }
		//페이징 전체 string, 총 페이지 수, 현재 블럭, 총 블럭 수 
		$pagination; $totalPage; $nowBlock; $totalBlock;
		
		$nowBlock = ceil($thisPage /$blockSize);
		if(($totalCount % $pageSize) > 0) {
			$totalPage = floor($totalCount / $pageSize) + 1;
		} else {
			$totalPage = floor($totalCount / $pageSize);
		}
		
		if(($totalCount % $blockSize) > 0) {
			$totalBlock = floor($totalCount / $blockSize) + 1;
		} else {
			$totalBlock = floor($totalCount / $blockSize);
		}		
		
		if ($firstEnd != false) {
            if ($firstBtn == false) {
                $firstBtn = '<li onclick="' . str_replace('-_-num-_-', '1', $link) . '">First</li>';
            } else {
                $firstBtn = str_replace('-_-num-_-', '1', $firstBtn);
            }
            if (endBtn == false) {
				$endBtn = '<li onclick="' . str_replace('-_-num-_-', $totalPage, $link) . '">End</li>';
            } else {
                $endBtn = str_replace('-_-num-_-', $totalPage, $endBtn);
            }
        } else {
            $firstBtn = '';
            $endBtn = '';
        }
		
		if ($totalPage > 1) {			
			$numblock = '';
            $fastblock = '';
            $nextblock = '';
            $startpage = '';
            $loopsize = '';
            $fastview = '';
            $nextview = '';

            $blockminus = ((int)($thisPage) - (int)($blockSize));
            $blockplus = ((int)($thisPage) + (int)($blockSize));

			if ($thisPage == 1) {
				if ($prevBtn == false) {					
					//$fastblock = '<li class="Pdisabled">Fast</li>';
					$fastblock = '';
				} else {
					//$fastblock = str_replace('-_-num-_-', '1', $prevBtn);
					//$fastblock = str_replace('-_-class-_-', 'Pdisabled', $fastblock);
					$fastblock = '';
				}

				if ($block == false) {					
                    if ($nextBtn == false) {
                        $nextblock = '<li onclick="' . str_replace('-_-num-_-', '2', $link) . '">Next</li>';
                    } else {
                        $nextblock = str_replace('-_-num-_-', '2', $nextBtn);
						$nextblock = str_replace('-_-class-_-', '', $nextblock);
                    }
				} else {
					if($blockplus <= $totalPage) {
						$nextview = $blockplus;
					} else {
						$nextview = $totalPage;
					}
					
					if($nextBtn == false) {
						$nextblock = '<li class="disable" onclick="' . str_replace('-_-num-_-', $nextview, $link) . '">Next</li>';
					} else {
						$nextblock = str_replace('-_-num-_-', $nextview, $nextblock);
						$nextblock = str_replace('-_-class-_-', '', $nextblock);
					}
				}				
				$startpage = 1;
                $loopsize = ($totalPage >= $blockSize) ? $blockSize : $totalPage;

			} else if ($thisPage == $totalPage) {
				if($nextBtn == false) {
					//$nextblock = '<li class="Pdisabled">End</li>';
					$nextblock = '';
				} else {
					//$nextblock = str_replace('-_-num-_-', $totalPage, $nextblock);
					//$nextblock = str_replace('-_-class-_-', 'Pdisabled', $nextblock);
					$nextblock = '';
				}
				
				if ($block == false) {
					if ($prevBtn == false) {
						$fastblock = '<li onclick="' . str_replace('-_-num-_-', (int)$thisPage - 1, $link) . '">Fast</li>';
					} else {
						$fastblock = str_replace('-_-num-_-', (int)$thisPage - 1, $prevBtn);
						$fastblock = str_replace('-_-class-_-', '', $fastblock);
					}
				} else {
					if($blockminus > 1) {
						$fastview = $blockminus;
					} else {
						$fastview = 1;
					}
					
					if ($prevBtn == false) {
                        $fastblock = '<li onclick="' . str_replace('-_-num-_-', $fastview, $link) . '">Fast</li>';
                    } else {
                        $fastblock = str_replace('-_-num-_-', $fastview, $prevBtn);
						$fastblock = str_replace('-_-class-_-', '', $fastblock);
                    }
				}
				
				$startpage = (($totalPage + 1 - $blockSize) <= 1) ? 1 : ($totalPage + 1 - $blockSize);
                $loopsize = $totalPage;
			} else {
				if ($block == false) {
					if ($prevBtn == false) {
						$fastblock = '<li onclick="' . str_replace('-_-num-_-', (int)$thisPage - 1, $link) . '">Fast</li>';
					} else {
						$fastblock = str_replace('-_-num-_-', (int)$thisPage - 1, $prevBtn);
						$fastblock = str_replace('-_-class-_-', '', $fastblock);
					}
					
					if ($nextBtn == false) {
                        $nextblock = '<li onclick="' . str_replace('-_-num-_-', (int)$thisPage + 1, $link) . '">Next</li>';
                    } else {
                        $nextblock = str_replace('-_-num-_-', (int)$thisPage + 1, $nextBtn);
						$nextblock = str_replace('-_-class-_-', '', $nextblock);
                    }
				} else {
					if (blockminus > 1) {
						$fastview = $blockminus;
					} else {
						$fastview = 1;
					}
					
					if ($prevBtn == false) {
                        $fastblock = '<li onclick="' . str_replace('-_-num-_-', $fastview, $link) . '">Fast</li>';
                    } else {
                        $fastblock = str_replace('-_-num-_-', $fastview, $prevBtn);
						$fastblock = str_replace('-_-class-_-', '', $fastblock);
                    }
					
					if ($blockplus <= $totalPage) {
						$nextview = $blockplus;
                    } else {
						$nextview = $totalPage;
                    }
					
					if($nextBtn == false) {
						$nextblock = '<li onclick="' . str_replace('-_-num-_-', $nextview, $link) . '">Next</li>';
					} else {
						$nextblock = str_replace('-_-num-_-', $nextview, $nextBtn);
						$nextblock = str_replace('-_-class-_-', '', $nextblock);
					}
				}
				
				$startpage = ((((int)($thisPage) - (int)($blockSize)) + 1) <= 1) ? 1 : (((int)($thisPage) - (int)($blockSize)) + 1);
                $loopsize = ($totalPage > (int)$blockSize) ? $start_page + $blockSize - 1 : $totalPage ;
			}

			for($i = $startpage; $i <= $loopsize; $i++) {
				if ($thisPage == $i) {
					if ($numBtn == false) {
						$numblock = $numblock . '<li class="Pdisabled">' . $i . '</li>';
					} else {
						$numblock = $numblock . str_replace('-_-num-_-', $i, $numBtn);
						$numblock = str_replace('-_-class-_-', 'Pdisabled select', $numblock);
					}
				} else {
					if ($numBtn == false) {
						$numblock = $numblock . '<li onclick="' . str_replace('-_-num-_-', $i, $link) . '">' . $i . '</li>';						
					} else {
						$numblock = $numblock . str_replace('-_-num-_-', $i, $numBtn);
						$numblock = str_replace('-_-class-_-', '', $numblock);
					}
				}
			}
			
			$pagination = $firstBtn . $fastblock . $numblock . $nextblock . $endBtn;
			return $pagination;

		} else {			
			if ($minShow == false) {
                return "";
            } else {
                if ($numBtn != '' || $numBtn != false) {
                    $pagination = str_replace('-_-num-_-', '1', $numBtn);
					$pagination = str_replace('-_-class-_-', 'Pdisabled', $pagination);
                    return $pagination;
                } else {
                    $pagination = '<li>1</li>';
                    return $pagination;
                }
            }
		}
		
	}
	
	//function custom_page()
	
	//총 레코드 수, 현재 페이지, 사용할 스크립트 명, 블럭이동 사용여부, 이동 버튼 표시유무, 뒤로가기버튼 html, 다음으로버튼 html, 처음으로버튼 html, 마지막으로버튼 html
	function paging($totalCount, $thisPage, $link, $block = false, $showFast = false, $prevBtn = false, $nextBtn = false, $firstBtn = false, $endBtn = false) {
		
		//총 페이지 수, 총 블럭 수, 시작페이지, 종료페이지, 현재블럭;
		$totalPage; $totalBlock; $startPage; $endPage; $thisBlock;
		
		//총 페이지 개수를 꺼내옴. 전체에서 페이지당 표시할 개수를 나누어 구함.
		if (($totalCount % $this->pageSize) > 0) {
			$totalPage = floor($totalCount / $this->pageSize) + 1;
		} else {
			$totalPage = floor($totalCount / $this->pageSize);
		}
		
		if($totalPage > 1) {

			//뒤로가기 버튼
			if($thisPage == 1) {
				if($showFast != false) {
					if($prevBtn == "") {
						$prevBtn = '<button class="prev_btn"> < </button>';
					}
				} else {
					$prevBtn = '';
				}
				
			} else {
				if($prevBtn == "") {
					$prevBtn = '<span onclick="javascript:' . $link . '(' . ($thisPage - 1) . ')"><button type="button" class="btn btn-danger"><img src="/img/pag_prev_btn.png" alt=""></button></span>';
				} else {
					$prevBtn = '<span onclick="javascript:' . $link . '(' . ($thisPage - 1) . ')">' . $prevBtn . '</span>';
				}
			}
			
			//처음으로 가기 버튼
			if($thisPage == 1) {
				if($showFast != false) {
					if($firstBtn == "") {
						$firstBtn = '<button class="first_btn"> << </button>';
					}
				} else {
					$firstBtn = "";
				}
			} else {
				if($firstBtn == "") {
					$firstBtn = '<span onclick="javascript:' . $link . '(1)"><button type="button" class="btn btn-danger"><img src="/img/pag_prev_btn_all.png" alt=""></button></span>';
				} else {
					$firstBtn = '<span onclick="javascript:' . $link . '(1)">' . $firstBtn . '</span>';
				}
				
			}
			
			//다음으로 버튼
			if($thisPage >= $totalPage) {
				if($showFast != false) {
					if($nextBtn == "") {
						$nextBtn = '<button class="next_btn"> > </button>';
					}
				} else {
					$nextBtn = '';
				}
			} else {
				if($nextBtn == "") {
					$nextBtn = '<span onclick="javascript:' . $link . '(' . ($thisPage + 1) . ')"><button type="button" class="btn btn-danger"><img src="/img/pag_next_btn.png" alt=""></button></span>';
				} else {
					$nextBtn = '<span onclick="javascript:' . $link . '(' . ($thisPage + 1) . ')">' . $nextBtn . '</span>';
				}
			}
			
			//마지막으로 가기 버튼
			if($thisPage >= $totalPage) {
				if($showFast != false) {
					if($endBtn == "") {
						$endBtn = '<button class="end_btn"> >> </button>';
					}
				} else {
					$endBtn = '';
				}			
			} else {
				if($endBtn == "") {
					$endBtn = '<span onclick="javascript:' . $link . '(' . $totalPage . ')"><button type="button" class="btn btn-danger"><img src="/img/pag_next_btn_all.png" alt=""></button></span>';
				} else {
					$endBtn = '<span onclick="javascript:' . $link . '(' . $totalPage . ')">' . $endBtn . '</span>';
				}
			}
			
			//페이지 번호
			$paging = ""; $i; $start_view; $end_view;
			//현재 페이지 기준으로 블럭 사이즈만큼만 표시. 현재 페이지가 한 블럭에 표시될 페이지보다 크면 가장 오른쪽에 위치.
			if($block == false) {
				if(($thisPage + 1 - $this->blockSize) >= 1) {
						$start_view = $thisPage + 1 - $this->blockSize;
				} else {
					$start_view = 1;
				}

				if($totalPage > $this->blockSize) {
					if($thisPage >= $totalPage) {
						$end_view = $start_view + $this->blockSize - 1;
					} else {
						$end_view = $start_view - 1 + $this->blockSize;
					}
				} else {
					$end_view = $totalPage;
				}

				for($i = $start_view; $i <= $end_view; $i++) {
					if($i == $thisPage) {
						$paging .= '<button type="button" class="btn btn-primary">' . $i . '</button>';
					} else {
						$paging .= '<span onclick="javascript:' . $link . '(' . $i . ')"><button type="button" class="btn btn-default">' . $i . '</button></span>';
					}
				}
			} 
			//페이지가 블럭을 넘어갈 때 블럭 범위도 이동.
			else {
				//총 블럭 수 구하기.
				if ($totalCount == 0) {
					$totalBlock = 1;			
				} else {
					$totalBlock = ceil($totalPage / $this->blockSize);
				}
				
				//현재 블럭값 구하기
				$thisBlock = ceil($thisPage / $this->blockSize);
				
				//시작 페이지 및 종료 페이지 구하기.
				//현재 블럭의 시작 번호를 구함.
				$blockStartView = ($thisBlock - 1) * $this->blockSize + 1;
				//현재 블럭의 끝 페이지를 구함.
				$blockEndView = $blockStartView + $this->blockSize - 1;
				
				//마지막 페이지가 총 페이지보다 클 경우 마지막 페이지는 전체 페이지와 같음.
				if ($blockEndView > $totalPage) {
					$blockEndView = $totalPage;			
				}
				
				//페이지 번호 표시
				$i; $endloop;
				$endloop = $this->blockSize + $blockStartView - 1;
				
				//현재 시작 블럭부터 블럭에 표시할 페이지 수만큼 page를 루프를 돌림 마지막 블럭일 경우에는 수가 모자를 수도 있기 때문에 end page만큼 돌린다.
				if (($endloop > $totalCount) || ($endloop > $blockEndView)) {
					$endloop = $blockEndView;			
				}
				
				for($i = $blockStartView; $i <= $endloop; $i++) {
					if($thisPage == $i) {
						$paging .= '<button type="button" class="btn btn-primary">' . $i . '</button>';
					} else {
						$paging .= '<span onclick="javascript:' . $link . '(' . $i . ')"><button type="button" class="btn btn-default">' . $i . '</button></span>';
					}
				}
				
				$prevNum = ($thisPage - $this->blockSize > 1) ? $thisPage - $this->blockSize : 1 ;
				$nextNum = ($thisPage + $this->blockSize >= $totalPage) ? $totalPage : $thisPage + $this->blockSize ;
				
				if($thisBlock > 1) {
					if($prevBtn == "") {
						$prevBtn = '<button class="prev_btn"> < </button>';
					}
				} else {
					if($prevBtn == "") {
						$prevBtn = '<span onclick="javascript:' . $link . '(' . $prevNum . ')"><button type="button" class="btn btn-danger">◀</button></span>';
					} else {
						$prevBtn = '<span onclick="javascript:' . $link . '(' . $prevNum . ')">' . $prevBtn . '</span>';
					}
				}
				
				if($thisBlock == $totalBlock) {
					if($nextBtn == "") {
						$nextBtn = '<button class="next_btn"> > </button>';
					}
				} else {
					if($nextBtn == "") {
						$nextBtn = '<span onclick="javascript:' . $link . '(' . $nextNum . ')"><button type="button" class="btn btn-danger">▶</button></span>';
					} else {
						$nextBtn = '<span onclick="javascript:' . $link . '(' . $nextNum . ')">' . $nextBtn . '</span>';
					}
				}
				
			}
			
			if($showFast == false) {
				$paging_view = $firstBtn . $prevBtn . $paging . $nextBtn . $endBtn;
			} else {
				$paging_view = $firstBtn . $prevBtn . $paging . $nextBtn . $endBtn;
			}
			
			return $paging_view;
		
		} else {
			return "";
		}
	}
}