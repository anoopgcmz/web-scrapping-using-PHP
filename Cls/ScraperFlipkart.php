<?php
namespace Cls;
error_reporting(E_ALL & ~E_NOTICE);
class ScraperFlipkart {


	public $searchString = "Iphone 6s";
	private $rawWebData;
    private $itemArry = [];
    private $sortArry = [];


	private $error = false;
	const URL = "https://www.flipkart.com/search?q=";
    const URLNew = "http://uae.souq.com/ae-en/";


/*
 *  Constructor
 */
	function __construct($searchString)
	{
		$this->searchString = $searchString;


		$this->connection();

		$this->scrapping();
        $this->parsing();



	}


    /**
     * Get the result
     * @return array :  Scraped  that is sorted data
     */
    public function getItemArry()
    {
        return json_encode($this->itemArry);
    }


    /*
     * Connection to outward URL using Curl
     */
	public function connection()
	{
		$curlflip = curl_init();
        $curlSouq = curl_init();

		curl_setopt($curlflip, CURLOPT_URL,self::URL.$this->searchString);
		curl_setopt($curlflip, CURLOPT_HEADER, 0);
		curl_setopt($curlflip, CURLOPT_TIMEOUT, 120);
		curl_setopt($curlflip, CURLOPT_RETURNTRANSFER, true);


        curl_setopt($curlSouq, CURLOPT_URL,self::URLNew.$this->searchString."/s/");
        curl_setopt($curlSouq, CURLOPT_HEADER, 0);
        curl_setopt($curlSouq, CURLOPT_TIMEOUT, 120);
        curl_setopt($curlSouq, CURLOPT_RETURNTRANSFER, true);

        $mh = curl_multi_init(); 

        curl_multi_add_handle($mh,$curlflip);
        curl_multi_add_handle($mh,$curlSouq);

        $active = null;

        if (curl_multi_select($mh) != -1) {
        do {
            $this->rawWebData = curl_multi_exec($mh);
         
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }

		

		//close the handles
        curl_multi_remove_handle($mh, $curlflip);
        curl_multi_remove_handle($mh, $curlSouq);
        curl_multi_close($mh);



	}


    /*
     * Scrapping (Get chunk of a data and discard the rest)
     */
	public function scrapping()
	{  


		if($this->error == false)
		{

			$dom = new \DOMDocument();

			@$dom->loadHTML($this->rawWebData);
			$xpath = new \DOMXPath($dom);


			$requiredBlock = $xpath->query("//div[@class='col col-3-12 col-md-3-12 MP_3W3']");  //Flipkart
            $requiredNewBlock = $xpath->query("//div[@class='placard']");// Souq

           //Scraping Flipkart
            $itemArry = [];
            $itemArryFlip = [];
            foreach ($requiredBlock as $content)
            {
                $imgpath = $title = $price = null;
                $tableRows1  = $xpath->query("div/a[@class='Zhf2z-']/div/div/div[@class='_3BTv9X']/img",$content);

                if($tableRows1->length >0)
                    $imgpath = $tableRows1->item(0)->getAttribute('src');
                else
                    $imgpath = "http://icons.iconarchive.com/icons/icons8/windows-8/256/City-No-Camera-icon.png";


                $tableRows2  = $xpath->query("div[@class='_3liAhj']/a[@class='_2cLu-l']",$content);
                if($tableRows2->length >0)
                    $title = $tableRows2->item(0)->getAttribute('title');


                $tableRows3  = $xpath->query("div/a[@class='_1Vfi6u']/div/div[@class='_1vC4OE']",$content);
                if($tableRows3->length >0)  
                    $price = $tableRows3->item(0)->textContent;

                if($price != null)
                {

                    if(is_numeric(substr($price,1)))
                    {
                        $currency = $price[0];
                        $cost = substr($price,1);

                    }
                    else
                    {
                        $currency = "";
                        $cost = $price;
                    }

                    $itemArry[] = ["img"=>$imgpath,"title"=>$title,"price"=>$cost,"currency"=>$currency];

                }

            }
            $FlipArray = $this->itemArry = $itemArryNew;
            //var_dump( $this->itemArry = $itemArryFlip);

            //Scraping Souqe.com
            $itemArryNew = [];
            foreach ($requiredNewBlock as $content)
            {
                $imgpath = $title = $price = null;
                $tableRows1  = $xpath->query("//div[@class='small-5 large-12 columns utilized']//img",$content);

                if($tableRows1->length >0)
                    $imgpath = $tableRows1->item(0)->getAttribute('src');
                else
                    $imgpath = "http://www.jetcharters.com/bundles/jetcharterspublic/images/image-not-found.jpg";


                $tableRows2  = $xpath->query("//div[@class='small-7 large-12 columns utilized']/h6/a",$content);
                if($tableRows2->length >0)
                    $title = $tableRows2->item(0)->getAttribute('title');


                $tableRows3  = $xpath->query("//div[@class='small-7 large-12 columns utilized']/h4",$content);
                if($tableRows3->length >0)  
                    $price = $tableRows3->item(0)->textContent;

                if($price != null)
                {

                    if(is_numeric(substr($price,1)))
                    {
                        $currency = $price[0];
                        $cost = substr($price,1);

                    }
                    else
                    {
                        $currency = "";
                        $cost = $price;
                    }

                    $itemArry[] = ["img"=>$imgpath,"title"=>$title,"price"=>$cost,"currency"=>$currency];

                }

            }
            $souqArray = $this->itemArry = $itemArryNew;
            //var_dump($this->itemArry = $itemArryNew);

            $itemArry = array_merge($FlipArray ,$souqArray); //Combining two array


		}

	}



    /*
     * Parsing (Parse the data into sortable arrays)
     */
	public function parsing ()
	{
        foreach($this->itemArry as $ky => $val)
        {
            $this->sortArry['price'][$ky] = $val['price'];
            $this->sortArry['title'][$ky] = $val['title'];

        }

	}


    //Sorting by price
	public function sorting ($by = "price")
	{
         
            uasort($this->sortArry[$by],function($a,$b)
                {
                    $a = ($a =="Free")?0:$a;
                    $b = ($b =="Free")?0:$b;

                    if ($a==$b) return 0;
                    return ($a<$b)?-1:1;
                }
            );
         
        $sAry = [];
        foreach($this->sortArry[$by] as $ky => $val)
        {
            $sAry[] = ["name"=>$this->itemArry[$ky]["title"],"image_url"=>$this->itemArry[$ky]["img"],"currency"=>$this->itemArry[$ky]["currency"],"price"=>$this->itemArry[$ky]["price"]];
        }
        $this->itemArry = $sAry;
 
    }




}