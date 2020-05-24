import React, {useEffect,useState} from "react";
import ReactDOM from "react-dom";
import {updatePropertyTitle,updatePropertyValue,updateProperty,destroyProperty,destroyPropertyValue} from "./propertiesActions";
import CreatePropertyValue from "./createPropertyValue";
const ProductProperties = ()=>{
    const [properties, setProperties] = useState(undefined);
    const [propertyName, setPropertyName] = useState("");
    const [propertySlug, setPropertySlug] = useState("");
    useEffect( ()=>{
        fetch('/office/properties.json')
            .then(response => {
                return response.json();
            })
            .then(data => {
                setProperties(data.data)
            });
    },[]);

    const refresh = ()=>{
        fetch('/office/properties.json')
            .then(response => {
                return response.json();
            })
            .then(data => {
                setProperties(data.data)
            });
    }

    const editPropertyTitle = (id,defaultValue)=>{
        updatePropertyTitle(id,defaultValue,refresh)
    }
    const editPropertyValue = (id,defaultValue)=>{
        updatePropertyValue(id,defaultValue,refresh)
        }
 const editProperty = (id,defaultValue)=>{
     updateProperty(id,defaultValue,refresh)
        }

        const deleteProperty = (id,defaultValue)=>{
            destroyProperty(id,defaultValue,refresh)
        }

        const deletePropertyValue = (id,defaultValue)=>{
            destroyPropertyValue(id,defaultValue,refresh)
        }

        const openCreateModal = (item)=>{
            setPropertyName(item.name)
            setPropertySlug(item.slug)
            $('#create_prop_modal').modal('show')
        }

    return(
    <React.Fragment>
        <CreatePropertyValue name={propertyName} slug={propertySlug} refresh={refresh}/>
        <div className="card bg-gray-100">
            <div className="card-body">
                <h5 className="card-title mb-4">Properties</h5>
                <div className="table-responsive">
                    <table className="table table-hover table-bordered" id="categories-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Values</th>
                        </tr>
                        </thead>
                        <tbody >
        {
            properties ?
                properties.map( (item, index)=>
            <tr key={index} className='p-2'>
                <td>
                    <div className="row">
                        <div className="col-4 pb-1">
                            {item.name}
                        </div>
                        <div className="col-8 d-flex justify-content-around">
                            <a className="btn" onClick={()=>deleteProperty(item.slug,item.name)}><i className="fas fa-trash"></i></a>
                            <a className="btn" onClick={()=>editProperty(item.slug,item.name)}><i className="fas fa-edit"></i></a>
                            <a className="btn" onClick={()=>openCreateModal(item)}><i className="fas fa-plus"></i></a>
                        </div>
                    </div>
                </td>

                <td>
                    <div className="row">
                        <div className="col-12 pb-1">
                            {
                                item.values ? item.values.length ?
                                    item.values.map( (property_value, property_value_index) =>
                                    <div className="d-inline font-weight-bold shadow-sm bg-gray-200 p-3 m-2 rounded cursor-pointer" key={property_value_index}>
                                        <span onClick={()=>editPropertyValue(property_value.id,property_value.value)}>{property_value.value}</span>
                                        {property_value.title.length > 1 ?
                                            <span className='bg-gray-100 p-2 m-2 rounded' onClick={()=>editPropertyTitle(property_value.id,property_value.title)}>{property_value.title}</span> : null
                                        }
                                        <span className="cursor-pointer m-2" onClick={()=>deletePropertyValue(property_value.id,property_value.title)}><i className="fas fa-trash"></i></span>

                                    </div>
                                    )
                                    : null
                                    : null
                            }

                        </div>

                    </div>
                </td>

            </tr>
                )
                : <tr>
                <td>Loading...</td>
                <td>Loading...</td>
                </tr>
        }
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </React.Fragment>
)
}


export default ProductProperties;

if (document.getElementById('product_properties')) {
    ReactDOM.render(<ProductProperties />, document.getElementById('product_properties'));
}
