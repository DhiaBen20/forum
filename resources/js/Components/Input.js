import React, { useEffect, useRef } from "react";

export default function Input({
    type = "text",
    name,
    className,
    isFocused,
    handleChange,
    ...prop
}) {
    const input = useRef();

    useEffect(() => {
        if (isFocused) {
            input.current.focus();
        }
    }, []);

    return (
        <div className="flex flex-col items-start">
            <input
                type={type}
                className={
                    `border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm ` +
                    className
                }
                name={name}
                ref={input}
                onChange={(e) => handleChange(e)}
                {...prop}
            />
        </div>
    );
}
