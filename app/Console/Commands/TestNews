<?php

namespace App\Console\Commands;

use App\Article;
use App\Group;
use Illuminate\Console\Command;
use NlpTools\Classifiers\MultinomialNBClassifier;
use NlpTools\Documents\TokensDocument;
use NlpTools\Documents\TrainingSet;
use NlpTools\FeatureFactories\DataAsFeatures;
use NlpTools\Models\FeatureBasedNB;
use NlpTools\Tokenizers\WhitespaceTokenizer;
use NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer;


class TestNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

  /**
   * @var \NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer
   */
    protected $tok;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->tok = new WhitespaceAndPunctuationTokenizer();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $article = Article::whereIn('id', [
            '46730f80-60d9-4f6e-81d6-1cbd729f2509',
            'c39c7358-15f3-4dce-90df-6c86940e6d0b'
          ])
          ->pluck('title');

        $groups = Article::orderBy('created_at','Desc')
          ->limit(500)
          ->get();

            //whereBetween('created_at',[
              //$article->created_at->subHours(12),
              //$article->created_at->addHours(12),
            //])
          //->where('id','!=',$article->id)
          //->all();

        //dd($groups);


        foreach ($groups as $articleGroups){
          if($this->inGroup([$articleGroups->title],$article) !== 0){
            $this->info($articleGroups->title);
          }
          //$this->info($article->title);
        }

    }


  private function inGroup($group,$news){
    $training = [];
    $tokens = [];

    foreach ($group as $key => $datum){
      $tokens = $this->tok->tokenize($datum);

      foreach ($tokens as $token){
        $training[] = [$token, $group[$key]];
      }
    }


    $newsArray = [];
    $newsToken = $this->tok->tokenize($news);
    foreach ($newsToken as $token){
      $newsArray[] = [$token, $news];
    }


    $tset = new TrainingSet(); // will hold the training documents
    $ff = new DataAsFeatures(); // see features in documentation

    // ---------- Training ----------------
    foreach ($training as $d) {
      $tset->addDocument(
        $d[0], // class
        new TokensDocument(
          $this->tok->tokenize($d[1]) // The actual document
        )
      );
    }

    $model = new FeatureBasedNB(); // train a Naive Bayes model
    $model->train($ff, $tset);


    // ---------- Classification ----------------
    $cls = new MultinomialNBClassifier($ff, $model);
    $correct = 0;
    foreach ($newsArray as $d) {
      // predict if it is spam or ham
      $prediction = $cls->classify(
        $tokens, // all possible classes
        new TokensDocument(
          $this->tok->tokenize($d[1]) // The document
        )
      );

      if ($prediction == $d[0])
        $correct++;
    }

    return 100 * $correct / count($group);
  }
}
