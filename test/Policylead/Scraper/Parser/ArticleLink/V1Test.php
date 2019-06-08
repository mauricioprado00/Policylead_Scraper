<?php

namespace Policylead\Scraper\Parser\ArticleLink;

class V1Test extends \Policylead\Scraper\TestCase 
{
    public function getTestCases()
    {
        return array(
            array(
                'politik.html',
                array (
                  '/politik/ausland/jared-kushner-hat-einen-plan-fuer-israel-und-palaestina-ohne-aussicht-auf-erfolg-a-1271481.html',
                  '/politik/deutschland/kevin-kuehnert-das-sagen-spon-leser-zum-juso-chef-a-1271484.html',
                  '/politik/ausland/kalter-krieg-usa-konnten-ostblock-durchgaengig-abhoeren-a-1271408.html',
                  '/politik/deutschland/news-kevin-kuehnert-andrea-nahles-heiko-maas-hongkong-a-1270630.html',
                  '/politik/deutschland/spd-nrw-landesvorstand-will-bundesparteitag-nicht-vorziehen-a-1271519.html',
                  '/politik/ausland/senegals-praesident-macky-sall-wehrt-sich-gegen-korruptionsvorwurf-a-1271217.html',
                  '/politik/deutschland/protestcamp-gegen-klimapolitik-umweltschuetzer-duerfen-vor-dem-am-kanzleramt-zelten-a-1271517.html',
                  '/politik/ausland/venezuela-ueber-vier-millionen-venezolaner-haben-krisenstaat-verlassen-a-1271522.html',
                  '/politik/ausland/usa-fordern-verlaengerung-der-deutschen-tornado-mission-ueber-syrien-a-1271518.html',
                  '/politik/deutschland/afd-klagt-offenbar-erneut-gegen-das-bundesamt-fuer-verfassungsschutz-a-1271513.html',
                  '/politik/ausland/syrien-mehr-als-100-tote-bei-kaempfen-um-rebellenhochburg-idlib-a-1271511.html',
                  '/politik/ausland/usa-setzen-tuerkei-frist-fuer-verzicht-auf-russische-raketen-a-1271510.html',
                  '/politik/deutschland/bremen-auch-spd-fuer-rot-gruen-rote-koalitionsverhandlungen-a-1271508.html',
                  '/politik/ausland/murtaja-qureiris-teenager-in-saudi-arabien-droht-die-todesstrafe-a-1271507.html',
                  '/politik/ausland/emmanuel-macron-bruchlandung-im-europaparlament-a-1271446.html',
                  '/politik/ausland/vereinigte-arabische-emirate-gehen-von-staatlichen-angriffen-aus-a-1271489.html',
                  '/politik/deutschland/horst-seehofer-innenminister-ueber-komplizierte-gesetze-kommentar-a-1271409.html',
                  '/politik/ausland/pazifik-beinahe-kollision-von-russischem-und-us-kriegsschiff-a-1271500.html',
                  '/politik/ausland/theresa-may-die-karriere-der-brexit-premierministerin-a-1271365.html',
                  '/politik/deutschland/news-des-tages-die-chancen-der-deutschen-bei-der-fussball-wm-der-frauen-2019-a-1271337.html',
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider getTestCases
     */
    public function articleLinksWillBeParsed($file, $expected)
    {
        $content = $this->readHtml($file);
        $parser = new V1();
        $actual = $parser->getArticleLinks($content);
        $this->assertEquals($expected, $actual);
    }
}