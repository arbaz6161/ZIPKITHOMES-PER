    @if(false)
    <!-- original embed form -->
    <iframe src="https://api.leadconnectorhq.com/widget/form/HSULIXUMWkKifj8RkW41"
        style="width:100%;height:100%;border:none;border-radius:3px" id="inline-HSULIXUMWkKifj8RkW41"
        data-layout="{'id':'INLINE'}" data-trigger-type="alwaysShow" data-trigger-value=""
        data-activation-type="alwaysActivated" data-activation-value=""
        data-deactivation-type="neverDeactivate" data-deactivation-value="" data-form-name="Interest Form"
        data-height="940" data-layout-iframe-id="inline-HSULIXUMWkKifj8RkW41"
        data-form-id="HSULIXUMWkKifj8RkW41" title="Interest Form">
    </iframe>
    @endif

    <!-- Olympic Plan -->
    @if(str_contains(strtolower($floorplan_name), 'olympic'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagHtwqnRAjokr9RU/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>
    
    <!-- Zip Pod XL 470 -->
    @elseif(str_contains(strtolower($floorplan_name), 'zip pod xl 470'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pag9sABHN5c0aF1fW/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>
    
    <!-- Yellowstone Pod -->
    @elseif(str_contains(strtolower($floorplan_name), 'yellowstone pod'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagxZNkTQavU4W9yN/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>
    
    <!-- Teton Studio -->
    @elseif(str_contains(strtolower($floorplan_name), 'teton studio'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagS9J6FJEbyEMw7d/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>
    
    <!-- Summit -->
    @elseif(str_contains(strtolower($floorplan_name), 'summit'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagQWVczeEkmzJJjY/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>
    
    <!-- Solitude XL -->
    @elseif(str_contains(strtolower($floorplan_name), 'solitude xl'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagIWfewmbYFP5Sob/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>
    
    <!-- Solitude -->
    @elseif(str_contains(strtolower($floorplan_name), 'solitude'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagn2tna9eTYBT4Kx/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>
    
    <!--Sierra - Landscape Hotel  -->
    @elseif(str_contains(strtolower($floorplan_name), 'sierra - landscape hotel'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/paghDVyYoRwLoiaEj/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>

    
    <!-- Shasta -->
    @elseif(str_contains(strtolower($floorplan_name), 'shasta'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pag3pcqJucQbStkQG/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>
    
    <!-- Ridgeline 840 -->
    @elseif(str_contains(strtolower($floorplan_name), 'ridgeline 840'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagPZZwQhB4ZUKpDd/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>

    <!-- Dakota -->
    @elseif(str_contains(strtolower($floorplan_name), 'dakota'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pag69tOnVMCF7SZge/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>

    <!-- Bozeman -->
    @elseif(str_contains(strtolower($floorplan_name), 'bozeman'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagysUgt0F7XmYYz9/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>

    <!-- Big Sky -->
    @else(str_contains(strtolower($floorplan_name), 'big sky'))
    <iframe id="frm_airtable_embed" class="airtable-embed" src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagyGepTtqRRQiuCN/form" frameborder="0" onmousewheel="" width="100%" height="2300" style="background: transparent; border: 1px solid #ccc;"></iframe>
    @endif


    
    @if(false)
    <iframe id="frm_airtable_embed" class="airtable-embed" 
        src="https://airtable.com/embed/appv9ypDSCB5m2Xqa/pagFEVzLYqUDTh2ey/form" 
        frameborder="0" 
        onmousewheel="" 
        width="100%" 
        height="1900" 
        style="background: transparent; border: 1px solid #ccc;">
    </iframe>
    @endif

<script>
  const iframe = document.getElementById('frm_airtable_embed');
  let loadCount = 0;

  iframe.addEventListener('load', () => {
    loadCount++;

    if (loadCount === 2) {
      // Likely the form has been submitted, and thank-you message is shown
      console.log("Redirecting after Airtable form submission...");
      window.location.href = "https://www.zipkithomes.com/thank-you/";
    }
  });
  
  
  
</script>