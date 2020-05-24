import React,{useState,useEffect} from "react";
import SuccessNotification from "../components/SuccessNotification"
import ErrorNotification from "../components/ErrorNotification"
import { useForm } from "react-hook-form";
const CreatePropertyValue = ({name,slug,refresh})=>{
    const { register, handleSubmit, clearError, errors } = useForm();
    const [propertyValue, setPropertyValue] = useState("");
    const [propertyTitle, setPropertyTitle] = useState("");
    const [process, setProcess] = useState(false);
    const [showSuccess, setShowSuccess] = useState(false);
    const [showError, setShowError] = useState(false);
    const [message, setMessage] = useState("");

    useEffect( ()=>{
        setProcess(false);
        setShowError(false);
        setShowSuccess(false);
    },[]);

    const save = (data)=>{
        // setProcess(true);
        // setShowError(false);
        // setShowSuccess(false);
        // const payload = {property_value:propertyValue,property_title:propertyTitle,property_slug:slug};
        // fetch('/office/properties/value/create',
        //     {
        //         method: 'POST',
        //         body:JSON.stringify(payload),
        //         headers: {
        //             'X-CSRF-TOKEN': window.appToken,
        //             'Content-Type': 'application/json'
        //         }
        //     }
        //     )
        //     .then(response => {
        //         if(response.status == 200){
        //             setShowSuccess(true);
        //             setMessage("Property value created");
        //             setProcess(false);
        //             refresh();
        //         }else{
        //             setShowError(true);
        //             setMessage(response.statusText);
        //             setProcess(false);
        //         }
        //
        //     })
        //     .catch(e=>{
        //     setShowError(true);
        //     setMessage(e.message);
        //     setProcess(false);
        // })
    }


    return(
        <div id='create_prop_modal' className="rounded-md modal fade">
            <div className="modal-dialog" role="document">
                <div className="modal-content">

            <div className="flex flex-col w-full h-auto ">
                <div className="flex w-full h-auto justify-center items-center">
                    <div className="flex w-10/12 h-auto py-3 justify-center items-center">
                       Add property value for <span className='text-2l font-bold pl-2'> {name}</span>
                    </div>
                    <div
                         className="flex w-1/12 h-auto justify-center cursor-pointer close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="#000000" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"
                             className="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>

                </div>
                <form onSubmit={()=>handleSubmit(save)}>
                <div className="flex w-full h-auto flex-col py-8 px-6 justify-center items-center bg-gray-200 rounded text-gray-500">
                    <SuccessNotification show={showSuccess} body={message}/>
                    <ErrorNotification show={showError} body={message}/>

                    <div className="flex flex-col mb-3 w-full">
                        <label htmlFor="property_value" className="self-start mb-2 font-medium">Property Value</label>
                        <input
                            ref={register({ required: true})}
                            type="text"
                            id="property_value"
                            name="property_value"
                            value={propertyValue}
                            disabled={process}
                            className="outline-none px-2 py-2 border shadow-sm rounded"
                            autoComplete="off"
                            onChange={(e)=>setPropertyValue(e.target.value)}
                        />
                        {errors.property_value && <span className='text-red-400'>A property value is required</span>}
                    </div>
                    <div className="flex flex-col mb-3 w-full">
                        <label htmlFor="title" className="self-start mb-2 font-medium">Title (optional)</label>
                        <input
                            type="text"
                            id="title"
                            value={propertyTitle}
                            placeholder=""
                            disabled={process}
                            className="outline-none px-2 py-2 border shadow-sm rounded"
                            autoComplete="off"
                            onChange={(e)=>setPropertyTitle(e.target.value)}
                        />
                    </div>
                    <div className="flex flex-col mb-3 w-full">
                    <button
                        type="submit"
                        disabled={process}
                        className="text-white bg-indigo-500 px-4 py-2 rounded"
                    >
                        {process ? "Saving..." : "Save"}
                    </button>
                    </div>
                </div>
                </form>
            </div>
                </div>
            </div>
        </div>
    )
}

export default CreatePropertyValue;
