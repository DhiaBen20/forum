import React, { useEffect, useRef } from 'react';

export default function Textarea({
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
            <textarea
                name={name}
                className={
                    `border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full ` +
                    className
                }
                ref={input}
                onChange={(e) => handleChange(e)}
                {...prop}
            />
        </div>
    );
}
