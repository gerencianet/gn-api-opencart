/**
 * Copy Pix Key
 * 
 * @param {string} copyText 
 * @param {string} button 
 */

 window.onload = () => {
    document.getElementById("btn-pix-copy").addEventListener("click", () => {

        /* Get the text field */
        const copyText = document.getElementById("input-pix-code").value;

        /* created element copy */
        const textarea = document.createElement("textarea");
        textarea.value = copyText;
        
        document.body.appendChild(textarea);

        /* Select the text field */
        textarea.select();
        textarea.setSelectionRange(0, textarea.value.length); /* For mobile devices */
        
        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Removed Element */
        document.body.removeChild(textarea);

        /* Animation to button copy*/
        const button = document.getElementById("btn-pix-copy");
        button.innerHTML = "Copiado &#10004";
        setTimeout(() => (button.innerHTML = "Copiar"), 1e3);
    });
}