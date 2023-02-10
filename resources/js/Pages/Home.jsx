import React, { useEffect } from "react";

function List({object}) {
    return Object.values(object).map(obj => <ul key={obj.id}>
        <li>
            {obj.name}
            {obj?.children ? <List object={obj.children}/> : <></>}
        </li>
    </ul>)
}

export default function Home({territories}) {
    return <>
        <h1>Territories</h1>
        <p>Here are the list of territories</p>

        {territories ? <List object={territories}/>: <></>}
    </>
}
