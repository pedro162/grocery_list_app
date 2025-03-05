export const BASE_URL = '' 

export const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

export const LOGOUT = ()=>{
    
}

export const GROCERY_LIST_STORE = (data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'POST',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/groceries',
        options:myInit
    } 
}


export const GROCERY_LIST_UPDATE = (id, data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'PUT',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/groceries/'+id,
        options:myInit
    } 
}
export const GROCERY_LIST_GET_ONE = (id, data = {})=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'GET',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
       // body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/groceries/'+id,
        options:myInit
    } 
}

export const GROCERY_LIST_LOAD = (data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'POST',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/groceries',
        options:myInit
    } 
}

export const GROCERY_LIST_ITENS = (data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'POST',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/grocery_items',
        options:myInit
    } 
}
export const GROCERY_LIST_GET_ITEMS = (id, data={})=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");
    
    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'GET',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        //body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/grocery_items?&grocery_id='+id,
        options:myInit
    } 
}


//------------------- PRODUCTS ENDPOINTS ---------------------------------------

export const PRODUCT_STORE = (data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");
    
    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'POST',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/products',
        options:myInit
    } 
}


export const PRODUCT_UPDATE = (id, data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");
    
    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'PUT',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/products/'+id,
        options:myInit
    } 
}
export const PRODUCT_GET_ONE = (id, data = {})=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");
    
    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'GET',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
       // body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/products/'+id,
        options:myInit
    } 
}

export const PRODUCT_LOAD = (data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");   
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'POST',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/products',
        options:myInit
    } 
}

//------------------- PRODUCT BRAND ENDPOINTS ---------------------------------------

export const PRODUCT_BRAND_STORE = (data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'POST',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/brands',
        options:myInit
    } 
}


export const PRODUCT_BRAND_UPDATE = (id, data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'PUT',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/brands/'+id,
        options:myInit
    } 
}
export const PRODUCT_BRAND_GET_ONE = (id, data = {})=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'GET',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
       // body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/brands/'+id,
        options:myInit
    } 
}

export const PRODUCT_BRAND_LOAD = (data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'GET',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        //body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/brands',
        options:myInit
    } 
}
//------------------- PRODUCT BRAND ENDPOINTS ---------------------------------------

export const PRODUCT_CATEGORY_STORE = (data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'POST',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/categories',
        options:myInit
    } 
}


export const PRODUCT_CATEGORY_UPDATE = (id, data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'PUT',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/categories/'+id,
        options:myInit
    } 
}
export const PRODUCT_CATEGORY_GET_ONE = (id, data = {})=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'GET',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
       // body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/categories/'+id,
        options:myInit
    } 
}

export const PRODUCT_CATEGORY_LOAD = (data)=>{
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json; charset=UTF-8");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("Accept", "application/json");

    data['csrfToken'] = CSRF_TOKEN;

    let myInit = { 
        method: 'GET',
        headers: myHeaders,
        //mode: 'cors',
        //cache: 'no-store',
        //body:JSON.stringify(data)
   };

   return{
        url:BASE_URL+'/api/categories',
        options:myInit
    } 
}
