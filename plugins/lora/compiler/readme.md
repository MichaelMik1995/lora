# Welcome to Template Compiler by @MiroKa

## Compiler is a plugin, which replaces vars from templates **{var}** to defined **$var**

**Example:**

<code>    
    <textarea name="{name}">{content}</textarea >    
</code>    

<?php
use Lora\Compiler\Compiler;
**$compiler** = new Compiler();
**$text** = "<textarea name='{name}'>{content}</textarea>";
**$compiler**->compile($text, ["{name}" => 'area', "{content}" => 'content']);
?>

**Output:**
<code>    
    <textarea name="**area**">**content**</textarea>    
</code>