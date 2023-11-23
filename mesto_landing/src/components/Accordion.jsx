import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from "./ui/accordion"

export default function () {
    return (
        <div className={"max-w-[1262px] mt-[5%] bg-white rounded-[48px] p-[32px] mx-auto text-[24px] text-[#020617] font-[500]"}>
            <Accordion type="single" collapsible className="w-full">
                <AccordionItem value="item-1">
                    <AccordionTrigger>Вопрос 1</AccordionTrigger>
                    <AccordionContent>
                        Задача организации, в особенности же новая модель организационной деятельности предопределяет
                    </AccordionContent>
                </AccordionItem>
                <AccordionItem className={"mt-[1%]"} value="item-2">
                    <AccordionTrigger>Вопрос 2</AccordionTrigger>
                    <AccordionContent>
                        Задача организации, в особенности же новая модель организационной деятельности предопределяет
                    </AccordionContent>
                </AccordionItem>
                <AccordionItem className={"my-[1%]"} value="item-3">
                    <AccordionTrigger>Вопрос 3</AccordionTrigger>
                    <AccordionContent>
                        Задача организации, в особенности же новая модель организационной деятельности предопределяет
                    </AccordionContent>
                </AccordionItem>
                <AccordionItem className={"mt-[1%]"} value="item-4">
                    <AccordionTrigger>Вопрос 4</AccordionTrigger>
                    <AccordionContent>
                        Задача организации, в особенности же новая модель организационной деятельности предопределяет
                    </AccordionContent>
                </AccordionItem>
                <AccordionItem className={"mt-[1%]"} value="item-5">
                    <AccordionTrigger>Вопрос 5</AccordionTrigger>
                    <AccordionContent>
                        Задача организации, в особенности же новая модель организационной деятельности предопределяет
                    </AccordionContent>
                </AccordionItem>
            </Accordion>
        </div>
    )
}