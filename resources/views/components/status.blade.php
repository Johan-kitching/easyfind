    @php
    if(in_array($status,['active','Link Live'])){
        $color='white';
    }elseif(in_array($status,['inactive','removed','Canceled'])){
        $color='negative';
    }elseif(in_array($status,['Quoted','PO Outstanding','Signed Quote'])){
        $color='blue';
    }elseif(in_array($status,['Ready to build','PO Outstanding'])){
        $color='orange';
    }elseif(in_array($status,['FAC Ready','PO Outstanding','Pending'])){
        $color='green';
    }elseif(in_array($status,['New Order','New', 'new'])){
        $color='cyan';
    }else{
        $color='';
    }
    @endphp
{{Str::ucfirst($label)}}
