import { Link } from "@inertiajs/react";

function PaginationLink({ link: { url, label }, ...props }) {
    return (
        <Link
            href={url}
            key={label}
            dangerouslySetInnerHTML={{ __html: label }}
            {...props}
        />
    );
}

function Pagination({ paginator }) {
    let { links } = paginator;

    return (
        !!paginator.data.length && (
            <div className="space-x-1 mt-8 text-center">
                <PaginationLink
                    link={links[0]}
                    className="px-2.5 py-2.5 rounded-md hover:bg-gray-200"
                />
                {links.slice(1, -1).map((link) => (
                    <PaginationLink
                        key={link.label}
                        link={link}
                        className={`px-4 py-2.5 rounded-md ${
                            link.active
                                ? "bg-gray-600 text-white"
                                : "hover:bg-gray-200"
                        }`}
                    />
                ))}
                <PaginationLink
                    link={links[links.length - 1]}
                    className="px-2.5 py-2.5 rounded-md hover:bg-gray-200"
                />
            </div>
        )
    );
}
// className="inline"

export default Pagination;
