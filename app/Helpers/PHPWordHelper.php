<?php

namespace App\Helpers;

class PHPWordHelper extends \PhpOffice\PhpWord\TemplateProcessor{

    protected $instance = null;
    // protected $tempDocumentMainPart = '';

    public function __construct($instance = null) 
    {      
        if($instance !== null) {
            $this->instance = $instance;
        }
    }
    

    // Replacement for PHPWord's cloneBlock
    public function replaceTplVars($blockname, $clones = 1, $replace = true)
    {
        // Parse the XML
        $xml = new \SimpleXMLElement($this->instance->tempDocumentMainPart);

        // Find the starting and ending tags
        $startNode = false; $endNode = false;
        foreach ($xml->xpath('//w:t') as $node)
        {
            if (strpos($node, '${'.$blockname.'}') !== false)
            {
                $startNode = $node;
                continue;
            }

            if (strpos($node, '${/'.$blockname.'}') !== false)
            {
                $endNode = $node;
                break;
            }
        }

        // Make sure we found the tags
        if ($startNode === false || $endNode === false)
        {
            return null;
        }

        // Find the parent <w:p> node for the start tag
        $node = $startNode; $startNode = null;
        while (is_null($startNode))
        {
            $node = $node->xpath('..')[0];

            if ($node->getName() == 'p')
            {
                $startNode = $node;
            }
        }

        // Find the parent <w:p> node for the end tag
        $node = $endNode; $endNode = null;
        while (is_null($endNode))
        {
            $node = $node->xpath('..')[0];

            if ($node->getName() == 'p')
            {
                $endNode = $node;
            }
        }

        /*
         * NOTE: Because SimpleXML reduces empty tags to "self-closing" tags.
         * We need to replace the original XML with the version of XML as
         * SimpleXML sees it. The following example should show the issue
         * we are facing.
         * 
         * This is the XML that my document contained orginally.
         * 
         * ```xml
         *  <w:p>
         *      <w:pPr>
         *          <w:pStyle w:val="TextBody"/>
         *          <w:rPr></w:rPr>
         *      </w:pPr>
         *      <w:r>
         *          <w:rPr></w:rPr>
         *          <w:t>${CLONEME}</w:t>
         *      </w:r>
         *  </w:p>
         * ```
         * 
         * This is the XML that SimpleXML returns from asXml().
         * 
         * ```xml
         *  <w:p>
         *      <w:pPr>
         *          <w:pStyle w:val="TextBody"/>
         *          <w:rPr/>
         *      </w:pPr>
         *      <w:r>
         *          <w:rPr/>
         *          <w:t>${CLONEME}</w:t>
         *      </w:r>
         *  </w:p>
         * ```
         */

        $this->instance->tempDocumentMainPart = $xml->asXml();

        // Find the xml in between the tags
        $xmlBlock = null;
        preg_match
        (
            '/'.preg_quote($startNode->asXml(), '/').'(.*?)'.preg_quote($endNode->asXml(), '/').'/is',
            $this->instance->tempDocumentMainPart,
            $matches
        );

        if (isset($matches[1]))
        {
            $xmlBlock = $matches[1];

            $cloned = array();

            for ($i = 1; $i <= $clones; $i++)
            {
                $cloned[] = preg_replace('/\${(.*?)}/','${$1_'.$i.'}', $xmlBlock);
            }

            if ($replace)
            {
                $this->instance->tempDocumentMainPart = str_replace
                (
                    $matches[0],
                    implode('', $cloned),
                    $this->instance->tempDocumentMainPart
                );
            }
        }

        return $xmlBlock;
    }
}