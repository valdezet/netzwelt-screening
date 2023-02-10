import React, { useState } from "react";

function ListItem({obj}) {
    let [expanded, setExpanded] = useState(false);

    let onListClick = (e) => {
        setExpanded(!expanded);
    }

    let {name, children} = obj;

    let liClasses = () => {
        return "list-item " + (children && (expanded ? "expanded" : "collapsed"));
    }

    return <li className={liClasses()} onClick={onListClick}>
        {name}
        {children && expanded ? <>
            <List object={children}/>
        </>  : <></>}
    </li>
}

function List({object}) {
    return Object.values(object).map(obj => <ul key={obj.id}>
        <ListItem obj={obj}/>
    </ul>)
}

export default function Home({territories}) {
    return <>
        <h1>Territories</h1>
        <p>Here are the list of territories</p>

        {territories ? <List object={territories}/>: <></>}
    </>
}
